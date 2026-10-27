<?php

use App\Support\PageLoader;
use App\Support\Translator\Translator;
use Illuminate\Support\Facades\Storage;
use Oneduo\NovaFileManager\Support\Asset;

if (! function_exists('img')) {
    /**
     * URL of a file manager image (Asset, {path} array or path string) on the public disk.
     */
    function img($href): string
    {
        if ($href instanceof Asset || isset($href->path)) {
            $href = $href->path;
        } elseif (is_array($href) && isset($href['path'])) {
            $href = $href['path'];
        }

        if (empty($href) || $href === 'null') {
            return '';
        }

        return preg_match('(storage|http)', $href)
            ? asset($href)
            : asset(Storage::url($href));
    }
}

if (! function_exists('lines')) {
    /**
     * The non-empty lines of a textarea ("one item per line" fields).
     */
    function lines(?string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', (string) $text))));
    }
}

if (! function_exists('page')) {
    /**
     * Content of a Nova page (see App\Nova\Templates), translated to the current locale.
     */
    function page(string $name): object
    {
        return app(PageLoader::class)->loadPage($name);
    }
}

if (! function_exists('getLocaleLabel')) {
    function getLocaleLabel($locale = ''): string
    {
        if (empty($locale)) {
            $locale = app()->getLocale();
        }

        return config('localizer.locales_labels.'.$locale, $locale);
    }
}

if (! function_exists('translator')) {
    function translator($text, $locale = null): mixed
    {
        return app(Translator::class)->array($text, $locale);
    }
}

if (! function_exists('is_nova_request')) {
    function is_nova_request(): bool
    {
        return request()->is('nova*');
    }
}

if (! function_exists('setting')) {
    /**
     * A value from the Nova settings page, falling back to $default while it is empty.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        $value = nova_get_setting($key);

        return blank($value) ? $default : $value;
    }
}
