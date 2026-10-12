@php
    $navLinks = [
        'home' => __('common.nav.home'),
        'about' => __('common.nav.about'),
        'services' => __('common.nav.services'),
        'expansion' => __('common.nav.expansion'),
        'blog.index' => __('common.nav.blog'),
    ];
@endphp

{{-- Transparent over the page top; turns into a glass panel once the page scrolls. Layer: z-100. --}}
<header data-header class="site-header fixed inset-x-0 top-0 z-100 p-12 md:p-16">
    <div class="header-bar mx-auto grid h-64 grid-cols-[1fr_auto] items-center gap-12 rounded-[22px] border border-transparent px-12 transition-colors duration-300 md:h-80 md:px-24 lg:grid-cols-[1fr_auto_1fr]">
        <a href="{{ route('home') }}" class="flex w-fit items-center gap-10" aria-label="{{ __('common.home_label') }}">
            <span class="grid h-40 w-40 place-items-center rounded-btn-small bg-paper text-ps font-bold text-ink">IM</span>
            <span class="text-p font-bold tracking-[0.16em] lg:hidden xl:inline">I&nbsp;MUST</span>
        </a>

        <nav class="hidden items-center gap-4 rounded-btn bg-ink/25 p-5 backdrop-blur-md lg:flex" aria-label="Main">
            @foreach ($navLinks as $route => $label)
                <a href="{{ route($route) }}" @if (request()->routeIs(str_replace('.index', '.*', $route))) aria-current="page" @endif
                   class="whitespace-nowrap rounded-btn px-12 py-10 text-ps font-semibold xl:px-18 text-paper/80 transition-colors hover:text-paper aria-[current=page]:bg-paper aria-[current=page]:text-ink">{{ $label }}</a>
            @endforeach
        </nav>

        <div class="flex items-center justify-end gap-8">
            @include('partials.language-switcher', ['class' => 'hidden lg:block'])
            <a href="{{ route('contact') }}" class="btn hidden bg-paper !py-12 text-ink hover:bg-white lg:inline-flex lg:!px-18 xl:!px-28">
                {{ __('common.cta_contact') }}
            </a>

            <button type="button" data-menu-toggle aria-expanded="false" aria-controls="mobile-menu"
                    class="grid h-44 w-44 place-items-center rounded-full bg-ink/25 text-paper backdrop-blur-md lg:hidden">
                <span class="sr-only">{{ __('common.toggle_menu') }}</span>
                <i class="ph ph-list text-[22px]" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <nav id="mobile-menu" data-menu class="glass-pill mt-8 hidden max-h-[calc(100dvh-104px)] overflow-y-auto rounded-[22px] p-12 lg:hidden" aria-label="Mobile">
        @foreach ($navLinks as $route => $label)
            <a href="{{ route($route) }}" @if (request()->routeIs(str_replace('.index', '.*', $route))) aria-current="page" @endif
               class="flex items-center justify-between rounded-btn px-16 py-14 text-h5 font-semibold text-paper hover:bg-white/5 aria-[current=page]:text-primary">
                {{ $label }}
                <i class="ph ph-arrow-right text-[20px] text-muted" aria-hidden="true"></i>
            </a>
        @endforeach
        <a href="{{ route('contact') }}" class="btn btn-primary mt-8 w-full">{{ __('common.cta_contact') }}</a>
        @include('partials.language-switcher', ['class' => 'mt-12', 'inline' => true])
    </nav>
</header>
