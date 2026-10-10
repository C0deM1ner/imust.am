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
    {{-- Hero: full-bleed photo, title top-left, package names across the bottom edge (each jumps to its card) --}}
    <section class="relative isolate flex min-h-[100dvh] flex-col justify-between overflow-hidden">
        <div class="cinema-media absolute inset-0 -z-1">
            {{-- TODO: replace with a real photo of the team at work. --}}
            <img src="https://picsum.photos/seed/imust-services-hero/2400/1500?grayscale" width="2400" height="1500"
                 alt="" fetchpriority="high" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-ink/45" aria-hidden="true"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-ink/80 via-ink/20 to-ink" aria-hidden="true"></div>
        </div>

        <div class="container pt-144 md:pt-180">
            <div class="max-w-5xl">
                <p class="eyebrow" data-reveal>{{ __('services.eyebrow') }}</p>
                <h1 class="mt-16 text-balance text-[40px] font-bold leading-[1.02] tracking-tight md:text-[64px] xl:text-[80px]" data-reveal style="--d:1">{{ __('services.title') }}</h1>
                <p class="mt-16 max-w-[48ch] text-p text-paper/80 md:text-pm" data-reveal style="--d:2">{{ __('services.lead') }}</p>
            </div>
        </div>

        <nav class="tier-words px-12 md:px-16" aria-label="{{ __('services.eyebrow') }}">
            @foreach ($packages as $key => $package)
                <a href="#{{ $key }}" class="transition-colors duration-300 hover:text-primary focus-visible:text-primary" data-reveal style="--d:{{ 3 + $loop->index }}">
                    <span class="sr-only">I MUST </span>{{ $package['tier'] }}
                </a>
            @endforeach
        </nav>
    </section>

    <section class="pb-40 pt-96 md:pt-144">
        <div class="container">
            @include('partials.package-cards', ['showDetails' => false])
        </div>
    </section>

    @include('partials.cta-band', ['title' => __('services.help.title'), 'lead' => __('services.help.lead')])
@endsection
