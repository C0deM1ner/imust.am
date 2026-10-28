<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Artisan;

trait RegeneratesSitemap
{
    public static function bootRegeneratesSitemap(): void
    {
        static::saved(fn () => Artisan::call('sitemap:generate'));
        static::deleted(fn () => Artisan::call('sitemap:generate'));
    }
}
