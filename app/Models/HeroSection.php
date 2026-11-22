<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_text',
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'secondary_button_text',
        'secondary_button_link',
        'image_url',
        'featured_product_id',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function featuredProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'featured_product_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
