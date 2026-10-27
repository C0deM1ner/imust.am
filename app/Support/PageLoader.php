<?php

namespace App\Support;

use App\Nova\Services\NovaPage\Models\StaticPage;
use Illuminate\Support\Facades\Cache;

class PageLoader
{
    protected function getPage($name)
    {
        $cacheKey = "static_page_{$name}";

        $page = Cache::rememberForever($cacheKey, function () use ($name) {
            return StaticPage::where('name', $name)->first()?->getAttributes();
        });

        if (empty($page)) {
            Cache::forget($cacheKey);
            abort(404, 'Page not found');
        }

        return $page;
    }

    public function loadPage($name): object
    {
        $page = $this->getPage($name);
        $content = translator($page['attributes']);

        return (object) $content;
    }
}
