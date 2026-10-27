{{--
    Full-bleed hero photo with a dark shade and gradient on top. Sits behind the section content.
    variant sets the overlay: home, article (about, blog post), office (contact),
    page (services), studio.
--}}
@props(['src', 'alt' => '', 'variant' => 'article', 'width' => 2400, 'height' => 1500])

@php
    // Literal class names so Tailwind keeps them in the build.
    $variants = [
        'home' => 'cinema-media-home',
        'article' => 'cinema-media-article',
        'office' => 'cinema-media-office',
        'page' => 'cinema-media-page',
        'studio' => 'cinema-media-studio',
    ];
@endphp

<div class="cinema-media {{ $variants[$variant] }}">
    <img src="{{ $src }}" width="{{ $width }}" height="{{ $height }}" alt="{{ $alt }}" fetchpriority="high">
    <div class="cinema-media-shade" aria-hidden="true"></div>
    <div class="cinema-media-gradient" aria-hidden="true"></div>
</div>
