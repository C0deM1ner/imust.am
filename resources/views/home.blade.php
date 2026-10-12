@extends('layouts.app')

@php
    // TODO: replace placeholder photography (picsum.photos) with real I MUST images.
    $roleImages = ['imust-marketing-team', 'imust-web-developer', 'imust-reel-shoot'];
@endphp

@section('content')
    {{-- Hero: cinematic full-bleed photo, message overlaid, wordmark across the bottom edge --}}
    <section class="relative isolate flex min-h-[100dvh] flex-col justify-end overflow-hidden">
        <div class="cinema-media absolute inset-0 -z-1">
            {{-- TODO: replace with a real team photo or a muted looping showreel <video>. --}}
            <img src="https://picsum.photos/seed/imust-hero-team/2400/1500?grayscale" width="2400" height="1500"
                 alt="{{ __('home.hero.image_alt') }}" fetchpriority="high" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-ink/40" aria-hidden="true"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/30 to-ink/60" aria-hidden="true"></div>
        </div>

        <div class="container pb-24 pt-144 md:pb-40">
            <div class="grid gap-32 md:grid-cols-12 md:items-end">
                <p class="text-[26px] font-medium leading-[1.2] md:col-span-7 md:text-[40px] xl:text-[48px]" data-reveal style="--d:4">
                    {{ __('home.hero.subtitle') }}
                </p>
                <div class="flex flex-col gap-12 xs:flex-row md:col-span-5 md:justify-end" data-reveal style="--d:5">
                    <a href="{{ route('services') }}" class="btn btn-primary">
                        {{ __('common.cta_services') }}
                        <i class="ph ph-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-glass">{{ __('home.hero.cta_team') }}</a>
                </div>
            </div>
        </div>

        {{-- Letters rise into place on load; each sits in its own clipping box. --}}
        <h1 class="hero-wordmark select-none px-12 md:px-16" aria-label="I MUST">
            @foreach (['I', ' ', 'M', 'U', 'S', 'T'] as $letter)
                <span class="letter-clip" aria-hidden="true">
                    <span class="hero-letter inline-block" style="--i:{{ $loop->index }}">{!! $letter === ' ' ? '&nbsp;' : e($letter) !!}</span>
                </span>
            @endforeach
        </h1>
    </section>

    {{-- Team: edge-to-edge photo triptych --}}
    <section class="pt-96 md:pt-144">
        <div class="container grid gap-24 pb-48 md:grid-cols-12 md:items-end md:pb-64">
            <h2 class="text-[34px] font-bold leading-[1.05] tracking-tight md:col-span-8 md:text-[56px] xl:text-[72px]" data-reveal>
                {{ __('home.team.title') }}
            </h2>
            <div class="md:col-span-4" data-reveal style="--d:1">
                <p class="text-p text-muted md:text-pm">{{ __('home.team.lead') }}</p>
                <a href="{{ route('about') }}" class="link-arrow mt-20">{{ __('home.team.link') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="grid gap-px bg-line lg:grid-cols-3">
            @foreach (__('home.team.roles') as $role)
                <a href="{{ route('about') }}" class="group relative isolate flex min-h-[400px] flex-col justify-end overflow-hidden bg-ink p-24 sm:min-h-[480px] md:min-h-[560px] md:p-40 lg:min-h-[88dvh] lg:p-32 xl:p-40"
                   data-reveal style="--d:{{ $loop->index }}">
                    <img src="https://picsum.photos/seed/{{ $roleImages[$loop->index] }}/1000/1600?grayscale" width="1000" height="1600" loading="lazy" alt="{{ $role['alt'] }}"
                         class="absolute inset-0 -z-1 h-full w-full object-cover opacity-70 transition duration-700 ease-out group-hover:scale-[1.04] group-hover:opacity-90">
                    <div class="absolute inset-0 -z-1 bg-gradient-to-t from-ink via-ink/40 to-ink/10" aria-hidden="true"></div>

                    <span class="glass-pill absolute right-24 top-24 grid h-48 w-48 place-items-center rounded-full transition-transform duration-300 group-hover:rotate-[-45deg] md:right-40 md:top-40" aria-hidden="true">
                        <i class="ph ph-arrow-right text-[20px]"></i>
                    </span>

                    <h3 class="text-[32px] font-bold leading-none tracking-tight md:text-[44px] lg:text-[32px] xl:text-[44px]">{{ $role['title'] }}</h3>
                    <p class="mt-12 max-w-[30ch] text-p text-paper/75 md:text-pm">{{ $role['text'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Packages: flat pricing cards (shared with the services page) --}}
    <section class="py-96 md:py-144">
        <div class="container">
            <div class="flex flex-col justify-between gap-20 pb-48 md:flex-row md:items-end md:pb-72" data-reveal>
                <h2 class="text-[34px] font-bold leading-[1.05] tracking-tight md:text-[56px] xl:text-[72px]">{{ __('home.packages.title') }}</h2>
                <a href="{{ route('services') }}" class="btn btn-glass w-fit">{{ __('common.cta_services') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
            </div>

            @include('partials.package-cards')
        </div>
    </section>

    {{-- Studio: full-bleed image, title word across the bottom edge (echoes the hero) --}}
    <section class="relative isolate flex min-h-[100dvh] flex-col justify-between overflow-hidden">
        <img src="https://picsum.photos/seed/imust-studio-lights/2400/1500?grayscale" width="2400" height="1500" loading="lazy" alt="{{ __('home.studio.image_alt') }}"
             class="absolute inset-0 -z-1 h-full w-full object-cover">
        <div class="absolute inset-0 -z-1 bg-gradient-to-b from-ink via-ink/40 to-ink/80" aria-hidden="true"></div>

        <div class="container pt-96 md:pt-144">
            <div class="max-w-2xl" data-reveal>
                <h2 class="text-[34px] font-bold leading-[1.05] tracking-tight md:text-[56px]">{{ __('home.studio.title') }}</h2>
                <p class="mt-16 text-p text-paper/80 md:text-pm">{{ __('home.studio.lead') }}</p>
                <a href="{{ route('expansion') }}" class="btn btn-glass mt-28">{{ __('home.studio.link') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <p class="studio-word select-none whitespace-nowrap px-12 md:px-16" aria-hidden="true" data-reveal>{{ __('common.nav.expansion') }}</p>
    </section>

    {{-- Closing call to action: full-bleed, large type --}}
    <section class="relative isolate overflow-hidden">
        <div class="container py-120 md:py-180">
            <h2 class="max-w-5xl text-[44px] font-bold leading-[1] tracking-[-0.03em] md:text-[88px] xl:text-[120px]" data-reveal>
                {{ __('home.cta.title') }}
            </h2>
            <div class="mt-40 flex flex-col gap-24 md:flex-row md:items-center md:justify-between" data-reveal style="--d:1">
                <p class="max-w-[46ch] text-p text-muted md:text-pm">{{ __('home.cta.lead') }}</p>
                <a href="{{ route('contact') }}" class="btn btn-primary w-fit !px-36 !py-18 md:!text-pl">
                    {{ __('common.cta_contact') }}
                    <i class="ph ph-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="pointer-events-none absolute -bottom-240 left-1/2 -z-1 h-[480px] w-[900px] -translate-x-1/2 rounded-full bg-primary/15 blur-[120px]" aria-hidden="true"></div>
    </section>
@endsection
