<?php

namespace App\Services;

use App\Exceptions\SlotFullException;
use App\Models\SlotQuota;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SlotAvailabilityService
{
    /**
     * Standard time slots available each day.
     *
     * @var array<string, string>
     */
    public const TIME_SLOTS = [
        '10:00' => '10.00 – 12.00',
        '13:00' => '13.00 – 15.00',
        '16:00' => '16.00 – 18.00',
    ];

    public function __construct(
        protected int $cutoffHour = 18,
        protected int $defaultCapacity = 5
    ) {
        if (function_exists('config') && app()->bound('config')) {
            $this->cutoffHour = (int) config('shop.schedule.cutoff_hour', $this->cutoffHour);
            $this->defaultCapacity = (int) config('shop.schedule.default_slot_capacity', $this->defaultCapacity);
        }
    }

    /**
     * Calculate the earliest date an order can be fulfilled based on lead time and 18:00 cutoff.
     */
    public function getEarliestAvailableDate(int $leadTimeDays = 1, ?Carbon $now = null): Carbon
    {
        $current = $now ? $now->copy() : Carbon::now('Asia/Makassar');
        $earliest = $current->copy()->startOfDay()->addDays($leadTimeDays);

        // If current hour has reached or passed cutoff hour (18:00), push date by +1 day
        if ($current->hour >= $this->cutoffHour) {
            $earliest->addDay();
        }

        return $earliest;
    }

    /**
     * Check if a specific target date is allowed given lead time and cutoff.
     */
    public function isDateAllowed(Carbon|string $targetDate, int $leadTimeDays = 1, ?Carbon $now = null): bool
    {
        $target = is_string($targetDate) ? Carbon::parse($targetDate)->startOfDay() : $targetDate->copy()->startOfDay();
        $earliest = $this->getEarliestAvailableDate($leadTimeDays, $now);

        return $target->greaterThanOrEqualTo($earliest);
    }

    /**
     * Get availability status of all slots for a given date.
     *
     * @return array<string, array{time_slot: string, label: string, is_available: bool, capacity: int, booked: int, remaining: int, reason: ?string}>
     */
    public function getAvailableSlots(Carbon|string $targetDate, int $leadTimeDays = 1, int $quantity = 1, ?Carbon $now = null): array
    {
        $date = is_string($targetDate) ? Carbon::parse($targetDate)->startOfDay() : $targetDate->copy()->startOfDay();
        $dateString = $date->format('Y-m-d');
        $isAllowed = $this->isDateAllowed($date, $leadTimeDays, $now);

        $quotas = SlotQuota::where(function ($q) use ($dateString) {
            $q->where('date', $dateString)
              ->orWhere('date', $dateString . ' 00:00:00');
        })->get()->keyBy('time_slot');

        $result = [];
        foreach (self::TIME_SLOTS as $slotKey => $slotLabel) {
            $quota = $quotas->get($slotKey);
            $capacity = $quota ? $quota->capacity : $this->defaultCapacity;
            $booked = $quota ? $quota->booked : 0;
            $remaining = max(0, $capacity - $booked);

            $available = $isAllowed && ($booked + $quantity <= $capacity);
            $reason = null;

            if (! $isAllowed) {
                $reason = 'Melewati batas waktu pemesanan (lead time / cut-off pukul 18.00)';
            } elseif ($booked + $quantity > $capacity) {
                $reason = 'Kuota slot penuh';
            }

            $result[$slotKey] = [
                'time_slot' => $slotKey,
                'label' => $slotLabel,
                'is_available' => $available,
                'capacity' => $capacity,
                'booked' => $booked,
                'remaining' => $remaining,
                'reason' => $reason,
            ];
        }

        return $result;
    }

    /**
     * Atomically reserve slot quota inside a DB transaction using pessimistic locking & conditional check.
     *
     * @throws SlotFullException
     */
    public function reserveSlot(Carbon|string $targetDate, string $timeSlot, int $quantity = 1, int $leadTimeDays = 1, ?Carbon $now = null): SlotQuota
    {
        $date = is_string($targetDate) ? Carbon::parse($targetDate)->startOfDay() : $targetDate->copy()->startOfDay();
        $dateString = $date->format('Y-m-d');

        if (! array_key_exists($timeSlot, self::TIME_SLOTS)) {
            throw new \InvalidArgumentException("Slot waktu {$timeSlot} tidak valid.");
        }

        if (! $this->isDateAllowed($date, $leadTimeDays, $now)) {
            throw new SlotFullException("Tanggal {$dateString} tidak memenuhi batas lead time atau telah melewati cut-off pukul 18.00.");
        }

        return DB::transaction(function () use ($dateString, $timeSlot, $quantity) {
            // Find existing slot with pessimistic locking (FOR UPDATE)
            $slot = SlotQuota::where(function ($q) use ($dateString) {
                $q->where('date', $dateString)
                  ->orWhere('date', $dateString . ' 00:00:00');
            })
            ->where('time_slot', $timeSlot)
            ->lockForUpdate()
            ->first();

            // If not found, safely create it handling race conditions / concurrent inserts
            if (! $slot) {
                try {
                    $slot = SlotQuota::create([
                        'date' => $dateString,
                        'time_slot' => $timeSlot,
                        'capacity' => $this->defaultCapacity,
                        'booked' => 0,
                    ]);
                    // Re-fetch with lock
                    $slot = SlotQuota::where('id', $slot->id)->lockForUpdate()->first();
                } catch (\Illuminate\Database\QueryException $e) {
                    // Handled concurrent insert collision (duplicate key / unique constraint)
                    $slot = SlotQuota::where(function ($q) use ($dateString) {
                        $q->where('date', $dateString)
                          ->orWhere('date', $dateString . ' 00:00:00');
                    })
                    ->where('time_slot', $timeSlot)
                    ->lockForUpdate()
                    ->first();

                    if (! $slot) {
                        throw $e;
                    }
                }
            }

            // Verify capacity vs booked under lock
            if (($slot->booked + $quantity) > $slot->capacity) {
                $remaining = max(0, $slot->capacity - $slot->booked);
                throw new SlotFullException(
                    "Slot waktu {$timeSlot} pada tanggal {$dateString} sudah penuh" . ($remaining > 0 ? " (tersisa {$remaining})." : ".")
                );
            }

            // Atomic increment
            $slot->increment('booked', $quantity);

            return $slot->fresh();
        });
    }

    /**
     * Atomically release / decrement booked slot quota.
     */
    public function releaseSlot(Carbon|string $targetDate, string $timeSlot, int $quantity = 1): void
    {
        $date = is_string($targetDate) ? Carbon::parse($targetDate)->startOfDay() : $targetDate->copy()->startOfDay();
        $dateString = $date->format('Y-m-d');

        DB::transaction(function () use ($dateString, $timeSlot, $quantity) {
            $slot = SlotQuota::where(function ($q) use ($dateString) {
                $q->where('date', $dateString)
                  ->orWhere('date', $dateString . ' 00:00:00');
            })
            ->where('time_slot', $timeSlot)
            ->lockForUpdate()
            ->first();

            if ($slot) {
                $newBooked = max(0, $slot->booked - $quantity);
                $slot->update(['booked' => $newBooked]);
            }
        });
    }

    /**
     * Suggest the nearest available slot starting from the preferred date and slot.
     *
     * @return array{date: string, time_slot: string, label: string, remaining: int}|null
     */
    public function suggestNearestAvailableSlot(
        Carbon|string $targetDate,
        string $preferredSlot,
        int $leadTimeDays = 1,
        int $quantity = 1,
        ?Carbon $now = null
    ): ?array {
        $earliest = $this->getEarliestAvailableDate($leadTimeDays, $now);
        $date = is_string($targetDate) ? Carbon::parse($targetDate)->startOfDay() : $targetDate->copy()->startOfDay();

        if ($date->lessThan($earliest)) {
            $date = $earliest->copy();
        }

        // Search up to 14 days ahead
        for ($i = 0; $i < 14; $i++) {
            $currentDate = $date->copy()->addDays($i);
            $availableSlots = $this->getAvailableSlots($currentDate, $leadTimeDays, $quantity, $now);

            // First check if preferred slot is available
            if ($availableSlots[$preferredSlot]['is_available'] ?? false) {
                return [
                    'date' => $currentDate->toDateString(),
                    'time_slot' => $preferredSlot,
                    'label' => self::TIME_SLOTS[$preferredSlot],
                    'remaining' => $availableSlots[$preferredSlot]['remaining'],
                ];
            }

            // Check other slots on the same day
            foreach ($availableSlots as $slotKey => $slotData) {
                if ($slotData['is_available']) {
                    return [
                        'date' => $currentDate->toDateString(),
                        'time_slot' => $slotKey,
                        'label' => $slotData['label'],
                        'remaining' => $slotData['remaining'],
                    ];
                }
            }
        }

        return null;
    }
}
