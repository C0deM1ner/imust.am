@php
    $navLinks = [
        'home' => __('common.nav.home'),
        'about' => __('common.nav.about'),
        'services' => __('common.nav.services'),
        'portfolio.index' => __('common.nav.portfolio'),
        'expansion' => __('common.nav.expansion'),
        'blog.index' => __('common.nav.blog'),
    ];
@endphp

{{-- ─── Header: transparent over the page top, glass once the page scrolls ─── --}}
<header data-header class="site-header">
    <div class="site-header-bar">
        <a href="{{ route('home') }}" class="site-logo" aria-label="{{ __('common.home_label') }}">
            <span class="site-logo-mark">IM</span>
            <span class="site-logo-text">I&nbsp;MUST</span>
        </a>

        <nav class="site-nav" aria-label="Main">
            @foreach ($navLinks as $route => $label)
                <a href="{{ route($route) }}" class="site-nav-link"
                   @if (Str::is(str_replace('.index', '.*', $route), Route::currentBaseName())) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
        </nav>

        <div class="site-header-actions">
            @include('partials.language-switcher', ['class' => 'hidden lg:block'])
            <a href="{{ route('contact') }}" class="btn btn-light site-header-cta">{{ __('common.cta_contact') }}</a>

            <button type="button" data-menu-open aria-expanded="false" aria-controls="mobile-menu" class="site-header-burger">
                <span class="sr-only">{{ __('common.toggle_menu') }}</span>
                <i class="ph ph-list" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</header>

{{-- ─── Mobile menu: full-screen overlay (same approach as the Sep project) ─── --}}
<div id="mobile-menu" data-menu role="dialog" aria-modal="true" aria-label="{{ __('common.toggle_menu') }}" class="mobile-menu">
    <div class="mobile-menu-top">
        <div class="mobile-menu-bar">
            <a href="{{ route('home') }}" class="site-logo" aria-label="{{ __('common.home_label') }}">
                <span class="site-logo-mark">IM</span>
                <span class="site-logo-text">I&nbsp;MUST</span>
            </a>
            <button type="button" data-menu-close class="mobile-menu-close">
                <span class="sr-only">{{ __('common.close_menu') }}</span>
                <i class="ph ph-x" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <nav class="mobile-menu-nav" aria-label="Mobile">
        @foreach ($navLinks as $route => $label)
            <a href="{{ route($route) }}" class="mobile-menu-link" style="--i:{{ $loop->index }}"
               @if (Str::is(str_replace('.index', '.*', $route), Route::currentBaseName())) aria-current="page" @endif>
                <span>{{ $label }}</span>
                <i class="ph ph-arrow-right" aria-hidden="true"></i>
            </a>
        @endforeach
    </nav>

    <div class="mobile-menu-footer">
        <a href="{{ route('contact') }}" class="btn btn-light w-full">{{ __('common.cta_contact') }}</a>
        @include('partials.language-switcher', ['class' => 'justify-center', 'inline' => true])
    </div>
</div>
