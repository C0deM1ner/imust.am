<?php

namespace App\Models;

use App\Models\Traits\IsActiveTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Oneduo\NovaFileManager\Casts\Asset;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasSlug;
    use HasTranslations;
    use IsActiveTrait;

    protected $fillable = [
        'slug',
        'is_active',
        'published_at',
        'category',
        'title',
        'excerpt',
        'body',
        'cover',
        'is_indexable',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
    ];

    protected array $translatable = [
        'category',
        'title',
        'excerpt',
        'body',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_indexable' => 'boolean',
        'published_at' => 'date',
        'cover' => Asset::class,
        'meta_image' => Asset::class,
    ];

    // One URL slug for every language, made from the English title.
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn (self $post) => $post->getTranslation('title', 'en', false))
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function scopeNewestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('published_at')->orderByDesc('id');
    }

    // About 200 words per minute.
    public function readingMinutes(): int
    {
        $words = count(preg_split('/\s+/u', trim(strip_tags((string) $this->body)), -1, PREG_SPLIT_NO_EMPTY));

        return max(1, (int) round($words / 200));
    }
}
