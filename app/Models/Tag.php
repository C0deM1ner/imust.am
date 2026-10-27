<?php

namespace App\Models;

use App\Models\Traits\IsActiveTrait;
use App\Models\Traits\SortByOrderTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Tag extends Model implements Sortable
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
        'name',
    ];

    protected array $translatable = [
        'name',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // The slug is the portfolio filter value (?tag=video), shared by all languages.
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn (self $tag) => $tag->getTranslation('name', 'en', false))
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
