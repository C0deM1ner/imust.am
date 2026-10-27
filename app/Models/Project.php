<?php

namespace App\Models;

use App\Models\Traits\IsActiveTrait;
use App\Models\Traits\SortByOrderTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Oneduo\NovaFileManager\Casts\Asset;
use Oneduo\NovaFileManager\Casts\AssetCollection;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Project extends Model implements Sortable
{
    use HasSlug;
    use HasTranslations;
    use IsActiveTrait;
    use SortableTrait;
    use SortByOrderTrait;

    protected $fillable = [
        'slug',
        'order',
        'is_active',
        'title',
        'client',
        'year',
        'summary',
        'challenge',
        'work',
        'result',
        'cover',
        'gallery',
        'is_indexable',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
    ];

    protected array $translatable = [
        'title',
        'client',
        'summary',
        'challenge',
        'work',
        'result',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_indexable' => 'boolean',
        'cover' => Asset::class,
        'gallery' => AssetCollection::class,
        'meta_image' => Asset::class,
    ];

    // One URL slug for every language, made from the English title.
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn (self $project) => $project->getTranslation('title', 'en', false))
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
