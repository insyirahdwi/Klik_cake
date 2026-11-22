<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotQuota extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time_slot',
        'capacity',
        'booked',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'capacity' => 'integer',
        'booked' => 'integer',
    ];

    /**
     * Ensure date is always normalized to Y-m-d format when set.
     */
    public function setDateAttribute($value): void
    {
        $this->attributes['date'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    /**
     * Ensure date is always returned in Y-m-d format.
     */
    public function getDateAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function remainingCapacity(): int
    {
        return max(0, $this->capacity - $this->booked);
    }

    public function isAvailable(int $quantity = 1): bool
    {
        return ($this->booked + $quantity) <= $this->capacity;
    }
}
