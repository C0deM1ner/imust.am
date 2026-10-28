<?php

namespace App\Nova\Services\NovaPage\Models;

use App\Models\Traits\RegeneratesSitemap;
use Illuminate\Database\Eloquent\Model;
use Oneduo\NovaFileManager\Casts\Asset;
use Spatie\Translatable\HasTranslations;

class StaticPage extends Model
{
    use HasTranslations;
    use RegeneratesSitemap;

    protected array $translatable = [
        'title',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    protected $fillable = [
        'type',
        'name',
        'title',
        'attributes',
        'is_indexable',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'meta_image',
    ];

    protected $casts = [
        'is_indexable' => 'boolean',
        'meta_image' => Asset::class,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::updated(function (StaticPage $staticPage) {
            $cacheKey = "static_page_{$staticPage->name}";

            cache()->forget($cacheKey);
            cache()->forever($cacheKey, $staticPage->getAttributes());
        });
    }
}
