@php
    $locales = config('app.locales');
    $current = app()->getLocale();
@endphp

@if ($inline ?? false)
    {{-- Inline row: mobile menu and footer --}}
    <nav class="{{ $class }} flex items-center gap-4 text-ps font-semibold" aria-label="{{ __('common.language') }}">
        @foreach ($locales as $code => $label)
            @if ($code === $current)
                <span class="rounded-btn bg-white/10 px-14 py-8 text-paper" aria-current="true" lang="{{ $code }}">{{ $label }}</span>
            @else
                <a href="{{ route(Route::currentRouteName(), array_filter(['locale' => $code, 'slug' => request()->route('slug')])) }}" hreflang="{{ $code }}" lang="{{ $code }}"
                   class="rounded-btn px-14 py-8 text-muted transition-colors hover:text-paper">{{ $label }}</a>
            @endif
        @endforeach
    </nav>
@else
    {{-- Compact dropdown: desktop header pill --}}
    <details data-lang-menu class="{{ $class }} group relative">
        <summary class="flex cursor-pointer list-none items-center gap-6 rounded-btn px-12 py-10 text-ps font-semibold text-paper/80 transition-colors hover:bg-white/5 hover:text-paper [&::-webkit-details-marker]:hidden"
                 aria-label="{{ __('common.language') }}">
            <i class="ph ph-globe-simple text-[18px]" aria-hidden="true"></i>
            {{ $locales[$current] }}
            <i class="ph ph-caret-down text-[12px] transition-transform group-open:rotate-180" aria-hidden="true"></i>
        </summary>
        <div class="glass-pill absolute right-0 top-[calc(100%+12px)] flex min-w-[120px] flex-col rounded-card p-6">
            @foreach ($locales as $code => $label)
                @if ($code === $current)
                    <span class="rounded-btn bg-white/10 px-14 py-10 text-ps font-semibold text-paper" aria-current="true" lang="{{ $code }}">{{ $label }}</span>
                @else
                    <a href="{{ route(Route::currentRouteName(), array_filter(['locale' => $code, 'slug' => request()->route('slug')])) }}" hreflang="{{ $code }}" lang="{{ $code }}"
                       class="rounded-btn px-14 py-10 text-ps font-semibold text-muted transition-colors hover:bg-white/5 hover:text-paper">{{ $label }}</a>
                @endif
            @endforeach
        </div>
    </details>
@endif
