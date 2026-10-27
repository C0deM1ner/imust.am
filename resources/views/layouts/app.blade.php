<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-ink">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', __('common.meta_description'))">
    <meta name="theme-color" content="#0D0F13">

    <title>@hasSection('full_title')@yield('full_title')@elseif (View::hasSection('title'))@yield('title') | I MUST @else{{ __('common.meta_title') }}@endif</title>

    {{-- SEO tab of the page in Nova (pages pass their page() content as $content). --}}
    @isset($content)
        @if (($content->is_indexable ?? true) === false)
            <meta name="robots" content="noindex">
        @endif
        @if ($metaImage = img($content->meta_image ?? null))
            <meta property="og:image" content="{{ $metaImage }}">
        @endif
        @if (! empty($content->meta_keywords))
            <meta name="keywords" content="{{ $content->meta_keywords }}">
        @endif
    @endisset

    @foreach (config('localizer.supported_locales') as $code)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ Route::localizedUrl($code) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ Route::localizedUrl(config('app.fallback_locale')) }}">

    {{-- Lets CSS hide [data-reveal] content only when JS will reveal it. --}}
    <script>document.documentElement.classList.add('js')</script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Armenian:wght@400;500;600;700&display=swap">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div data-header-sentinel class="header-sentinel" aria-hidden="true"></div>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
