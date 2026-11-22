<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author_name',
        'is_published',
        'published_at',
        'view_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'view_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($article) {
            if (empty($article->slug) && filled($article->title)) {
                $article->slug = Str::slug($article->title);
            }
            if ($article->is_published && empty($article->published_at)) {
                $article->published_at = now();
            }
            if (empty($article->excerpt) && filled($article->content)) {
                $article->excerpt = Str::limit(strip_tags($article->content), 150);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function readingTimeMinutes(): int
    {
        $words = str_word_count(strip_tags($this->content));
        return max(1, (int) ceil($words / 200));
    }

    public function formattedPublishedDate(): string
    {
        if (! $this->published_at) {
            return $this->created_at ? $this->created_at->translatedFormat('d F Y') : '-';
        }

        return $this->published_at->translatedFormat('d F Y');
    }
}
