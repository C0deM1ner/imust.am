@extends('layouts.app')

@section('title', __('services.meta_title'))
@section('description', __('services.meta_description'))

@php
    // Package names are brand names and stay the same in every language.
    $packages = [
        'start' => ['tier' => 'Start'],
        'grow' => ['tier' => 'Grow'],
        'maintain' => ['tier' => 'Maintain'],
    ];
@endphp

@section('content')
    {{-- ─── Hero: full-bleed photo, title top-left, package names across the bottom edge (each jumps to its card) ─── --}}
    <section class="page-hero page-hero-split">
        {{-- TODO: replace with a real photo of the team at work. --}}
        <x-cinema-media src="https://picsum.photos/seed/imust-services-hero/2400/1500?grayscale" variant="page" />

        <div class="container page-hero-top">
            <div class="max-w-5xl">
                <p class="eyebrow" data-reveal>{{ __('services.eyebrow') }}</p>
                <h1 class="hero-title" data-reveal style="--d:1">{{ __('services.title') }}</h1>
                <p class="hero-lead hero-lead-narrow" data-reveal style="--d:2">{{ __('services.lead') }}</p>
            </div>
        </div>

        <nav class="tier-words" aria-label="{{ __('services.eyebrow') }}">
            @foreach ($packages as $key => $package)
                <a href="#{{ $key }}" data-reveal style="--d:{{ 3 + $loop->index }}">
                    <span class="sr-only">I MUST </span>{{ $package['tier'] }}
                </a>
            @endforeach
        </nav>
    </section>

    {{-- ─── Packages ─── --}}
    <section class="services-packages">
        <div class="container">
            @include('partials.package-cards', ['showDetails' => false])
        </div>
    </section>

    @include('partials.cta-band', ['title' => __('services.help.title'), 'lead' => __('services.help.lead')])
@endsection
