@extends('layouts.app')

@php($offeringIcons = ['ph-graduation-cap', 'ph-presentation', 'ph-camera', 'ph-video-camera'])

@section('title', $content->meta_title ?: $content->title)
@section('description', $content->meta_description ?: __('common.meta_description'))

@section('content')
    {{-- ─── Hero: full-bleed photo, title top-left, giant "Studio" word across the bottom edge ─── --}}
    <section class="page-hero page-hero-split">
        <x-cinema-media :src="img($content->hero_image)" :alt="$content->hero_image_alt" variant="studio" />

        <div class="container page-hero-top">
            <div class="max-w-3xl">
                <p class="eyebrow" data-reveal>{{ $content->hero_eyebrow }}</p>
                <h1 class="hero-title" data-reveal style="--d:1">{{ $content->hero_title }}</h1>
                <p class="hero-lead hero-lead-narrow" data-reveal style="--d:2">{{ $content->hero_lead }}</p>
            </div>
        </div>

        <p class="studio-word" aria-hidden="true">{{ __('common.nav.expansion') }}</p>
    </section>

    {{-- ─── Offerings: full-width photo panels that stack as you scroll (position: sticky) ─── --}}
    <section class="expansion-offerings">
        <div class="container">
            <ol class="expansion-offerings-list">
                @foreach ($content->offerings ?? [] as $offering)
                    @php($offering = $offering['attributes'])
                    <li class="sticky" style="top: calc(96px + {{ $loop->index }} * 20px)">
                        <article class="expansion-panel">
                            <img src="{{ img($offering['image'] ?? null) }}" width="1024" height="617" loading="lazy" alt="{{ $offering['image_alt'] ?? '' }}" class="expansion-panel-img">
                            <div class="expansion-panel-shade" aria-hidden="true"></div>

                            <div class="expansion-panel-grid">
                                <div class="expansion-panel-heading">
                                    <i class="ph-light {{ $offeringIcons[$loop->index] ?? 'ph-sparkle' }} expansion-panel-icon" aria-hidden="true"></i>
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

    @include('partials.cta-band', ['title' => $content->cta_title, 'lead' => $content->cta_lead])
@endsection
