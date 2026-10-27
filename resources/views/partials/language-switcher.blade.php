@php
    $locales = config('localizer.locales_labels');
    $current = app()->getLocale();
    $urlFor = fn ($code) => Route::localizedSwitcherUrl($code);
@endphp

@if ($inline ?? false)
    {{-- Inline row: mobile menu --}}
    <nav class="lang-inline {{ $class }}" aria-label="{{ __('common.language') }}">
        @foreach ($locales as $code => $label)
            @if ($code === $current)
                <span class="lang-inline-item is-active" aria-current="true" lang="{{ $code }}">{{ $label }}</span>
            @else
                <a href="{{ $urlFor($code) }}" class="lang-inline-item" hreflang="{{ $code }}" lang="{{ $code }}">{{ $label }}</a>
            @endif
        @endforeach
    </nav>
@else
    {{-- Compact dropdown: desktop header --}}
    <details data-lang-menu class="lang-menu {{ $class }}">
        <summary class="lang-menu-trigger" aria-label="{{ __('common.language') }}">
            <i class="ph ph-globe-simple lang-menu-globe" aria-hidden="true"></i>
            {{ $locales[$current] }}
            <i class="ph ph-caret-down lang-menu-caret" aria-hidden="true"></i>
        </summary>
        <div class="glass-pill lang-menu-panel">
            @foreach ($locales as $code => $label)
                @if ($code === $current)
                    <span class="lang-menu-item is-active" aria-current="true" lang="{{ $code }}">{{ $label }}</span>
                @else
                    <a href="{{ $urlFor($code) }}" class="lang-menu-item" hreflang="{{ $code }}" lang="{{ $code }}">{{ $label }}</a>
                @endif
            @endforeach
        </div>
    </details>
@endif
