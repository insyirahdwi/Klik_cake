<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Networking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'platform',
        'url',
        'address',
        'phone',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeSocial(Builder $query): Builder
    {
        return $query->active()->where('type', 'social_media');
    }

    public function scopeOutlets(Builder $query): Builder
    {
        return $query->active()->whereIn('type', ['outlet', 'kitchen']);
    }

    public function scopePartners(Builder $query): Builder
    {
        return $query->active()->whereIn('type', ['partner', 'reseller']);
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'social_media' => 'Media Sosial',
            'outlet' => 'Cabang / Outlet',
            'kitchen' => 'Dapur Produksi',
            'partner' => 'Mitra Kolaborasi',
            'reseller' => 'Mitra Reseller',
            default => ucfirst($this->type),
        };
    }
}
