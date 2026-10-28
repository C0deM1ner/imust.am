<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-ink">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0D0F13">

    {{-- Each view sets its tags with <x-meta>; a view without one gets the site defaults. --}}
    @sectionMissing('meta')
        <x-meta />
    @endif
    @yield('meta')

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
