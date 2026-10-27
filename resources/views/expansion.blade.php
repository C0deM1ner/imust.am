@extends('layouts.app')

@section('title', __('expansion.meta_title'))
@section('description', __('expansion.meta_description'))

@php
    // TODO: replace placeholder photography (picsum.photos) with real studio images.
    $offeringMedia = [
        ['icon' => 'ph-graduation-cap', 'seed' => 'imust-studio-education'],
        ['icon' => 'ph-presentation', 'seed' => 'imust-studio-hall'],
        ['icon' => 'ph-camera', 'seed' => 'imust-studio-photozone'],
        ['icon' => 'ph-video-camera', 'seed' => 'imust-studio-production'],
    ];
@endphp

@section('content')
    {{-- ─── Hero: full-bleed photo, title top-left, giant "Studio" word across the bottom edge ─── --}}
    <section class="page-hero page-hero-split">
        <x-cinema-media src="https://picsum.photos/seed/imust-studio-hero/2400/1500?grayscale" :alt="__('expansion.image_alt')" variant="studio" />

        <div class="container page-hero-top">
            <div class="max-w-3xl">
                <p class="eyebrow" data-reveal>{{ __('expansion.eyebrow') }}</p>
                <h1 class="hero-title" data-reveal style="--d:1">{{ __('expansion.title') }}</h1>
                <p class="hero-lead hero-lead-narrow" data-reveal style="--d:2">{{ __('expansion.lead') }}</p>
            </div>
        </div>

        <p class="studio-word" aria-hidden="true">{{ __('common.nav.expansion') }}</p>
    </section>

    {{-- ─── Offerings: full-width photo panels that stack as you scroll (position: sticky) ─── --}}
    <section class="expansion-offerings">
        <div class="container">
            <ol class="expansion-offerings-list">
                @foreach (__('expansion.offerings') as $offering)
                    @php($media = $offeringMedia[$loop->index] ?? ['icon' => 'ph-sparkle', 'seed' => 'imust-studio-'.$loop->index])
                    <li class="sticky" style="top: calc(96px + {{ $loop->index }} * 20px)">
                        <article class="expansion-panel">
                            <img src="https://picsum.photos/seed/{{ $media['seed'] }}/2000/1200?grayscale" width="2000" height="1200" loading="lazy" alt="{{ $offering['alt'] }}" class="expansion-panel-img">
                            <div class="expansion-panel-shade" aria-hidden="true"></div>

                            <div class="expansion-panel-grid">
                                <div class="expansion-panel-heading">
                                    <i class="ph-light {{ $media['icon'] }} expansion-panel-icon" aria-hidden="true"></i>
                                    <h2 class="expansion-panel-title">{{ $offering['title'] }}</h2>
                                </div>
                                <p class="expansion-panel-text">{{ $offering['text'] }}</p>
                            </div>
                        </article>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    @include('partials.cta-band', ['title' => __('expansion.cta.title'), 'lead' => __('expansion.cta.lead')])
@endsection
