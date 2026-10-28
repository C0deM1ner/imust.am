@extends('layouts.app')

@php($packages = App\Nova\Templates\ServicesPage::PACKAGES)

<x-meta :page="$content" :image="$content->hero_image" />

@section('content')
    {{-- ─── Hero: full-bleed photo, title top-left, package names across the bottom edge (each jumps to its card) ─── --}}
    <section class="page-hero page-hero-split">
        <x-cinema-media :src="img($content->hero_image)" variant="page" />

        <div class="container page-hero-top">
            <div class="max-w-5xl">
                <p class="eyebrow" data-reveal>{{ $content->hero_eyebrow }}</p>
                <h1 class="hero-title" data-reveal style="--d:1">{{ $content->hero_title }}</h1>
                <p class="hero-lead hero-lead-narrow" data-reveal style="--d:2">{{ $content->hero_lead }}</p>
            </div>
        </div>

        <nav class="tier-words" aria-label="{{ $content->hero_eyebrow }}">
            @foreach ($packages as $key => $package)
                <a href="#{{ $key }}" data-reveal style="--d:{{ 3 + $loop->index }}">
                    <span class="sr-only">I MUST </span>{{ $package }}
                </a>
            @endforeach
        </nav>
    </section>

    {{-- ─── Packages ─── --}}
    <section class="services-packages">
        <div class="container">
            @include('partials.package-cards', ['services' => $content, 'showDetails' => false])
        </div>
    </section>

    @include('partials.cta-band', ['title' => $content->help_title, 'lead' => $content->help_lead])
@endsection
