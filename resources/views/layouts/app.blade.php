<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-ink">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', __('common.meta_description'))">
    <meta name="theme-color" content="#0D0F13">

    <title>@hasSection('title')@yield('title') | I MUST @else{{ __('common.meta_title') }}@endif</title>

    @foreach (array_keys(config('app.locales')) as $code)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ route(Route::currentRouteName(), array_filter(['locale' => $code, 'slug' => request()->route('slug')])) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ route(Route::currentRouteName(), array_filter(['locale' => array_key_first(config('app.locales')), 'slug' => request()->route('slug')])) }}">

    {{-- Lets CSS hide [data-reveal] content only when JS will reveal it. --}}
    <script>document.documentElement.classList.add('js')</script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Armenian:wght@400;500;600;700&display=swap">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div data-header-sentinel class="pointer-events-none absolute inset-x-0 top-0 h-8" aria-hidden="true"></div>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
