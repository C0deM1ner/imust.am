<?php

namespace App\Nova\Services\NovaPage\Models;

use Illuminate\Database\Eloquent\Model;
use Oneduo\NovaFileManager\Casts\Asset;
use Spatie\Translatable\HasTranslations;

class StaticPage extends Model
{
    use HasTranslations;

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

        static::updated(fn (StaticPage $staticPage) => cache()->forget("static_page_{$staticPage->name}"));
    }
}
