{{-- SEO, Open Graph and Twitter tags. The SEO tab in Nova ($page->meta_*) wins over the fallbacks a view passes in. --}}
@props([
    'page' => null,
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
    'published' => null,
])
@php
    $title = ($page->meta_title ?? null) ?: $title ?: ($page->title ?? null) ?: __('common.meta_title');
    // The brand is added once, so a title that already names it (the home page) stays as it is.
    $fullTitle = Str::contains($title, 'I MUST') ? $title : $title.' | I MUST';
    $description = ($page->meta_description ?? null) ?: $description;
    $description = Str::limit(trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags((string) $description)))), 160) ?: __('common.meta_description');
    $keywords = trim(preg_replace('/\s*\n\s*/', ', ', (string) ($page->meta_keywords ?? '')));
    $image = img($page->meta_image ?? null) ?: img($image) ?: asset('img/share.jpg');
    $isIndexable = ($page->is_indexable ?? true) !== false;
    $url = Request::url();
    $ogLocales = ['hy' => 'hy_AM', 'ru' => 'ru_RU', 'en' => 'en_US'];
@endphp
@section('meta')
    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $description }}">
    @if ($keywords)
        <meta name="keywords" content="{{ $keywords }}">
    @endif
    <link rel="canonical" href="{{ $url }}">

    <meta property="og:site_name" content="I MUST">
    <meta property="og:type" content="{{ $type }}">
    <meta property="og:url" content="{{ $url }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $image }}">
    <meta property="og:locale" content="{{ $ogLocales[app()->getLocale()] ?? app()->getLocale() }}">
    @foreach (array_diff_key($ogLocales, [app()->getLocale() => true]) as $ogLocale)
        <meta property="og:locale:alternate" content="{{ $ogLocale }}">
    @endforeach
    @if ($published)
        <meta property="article:published_time" content="{{ $published->toIso8601String() }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $image }}">

    @if ($isIndexable)
        @foreach (config('localizer.supported_locales') as $code)
            <link rel="alternate" hreflang="{{ $code }}" href="{{ Route::localizedUrl($code) }}">
        @endforeach
        <link rel="alternate" hreflang="x-default" href="{{ Route::localizedUrl(config('app.fallback_locale')) }}">
    @else
        <meta name="robots" content="noindex, follow">
    @endif
@endsection
