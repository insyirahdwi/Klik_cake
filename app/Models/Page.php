<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_description',
        'is_published',
        'show_in_header',
        'show_in_footer',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'show_in_header' => 'boolean',
        'show_in_footer' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($page) {
            if (empty($page->slug) && filled($page->title)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
