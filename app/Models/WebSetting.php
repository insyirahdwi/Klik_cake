<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class WebSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
        'type',
    ];

    protected static function booted()
    {
        static::saved(function ($setting) {
            Cache::forget('web_setting_' . $setting->key);
            Cache::forget('web_settings_all');
        });

        static::deleted(function ($setting) {
            Cache::forget('web_setting_' . $setting->key);
            Cache::forget('web_settings_all');
        });
    }

    /**
     * Get a single setting by key. Uses batch-loaded cache when available.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        // Try batch cache first (loaded by getMany)
        $all = Cache::get('web_settings_all');
        if (is_array($all) && array_key_exists($key, $all)) {
            return $all[$key] ?? $default;
        }

        return Cache::remember('web_setting_' . $key, 3600, function () use ($key, $default) {
            $record = static::where('key', $key)->first();
            return $record?->value ?? $default;
        });
    }

    /**
     * Load multiple settings in a single query and cache them.
     * Returns an associative array of key => value.
     */
    public static function getMany(array $keys, array $defaults = []): array
    {
        return Cache::remember('web_settings_all', 3600, function () use ($keys, $defaults) {
            $records = static::whereIn('key', $keys)->pluck('value', 'key')->toArray();
            $result = [];
            foreach ($keys as $key) {
                $result[$key] = $records[$key] ?? ($defaults[$key] ?? null);
            }
            return $result;
        });
    }

    public static function set(string $key, ?string $value, string $group = 'general', ?string $label = null, string $type = 'text'): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'label' => $label ?? ucwords(str_replace('_', ' ', $key)),
                'type' => $type,
            ]
        );

        Cache::forget('web_setting_' . $key);
        Cache::forget('web_settings_all');

        return $setting;
    }
}
