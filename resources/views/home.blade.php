@extends('layouts.app')

@php
    // TODO: AI-generated photography (Gemini). Replace with real I MUST photos when available.
    $roleImages = ['images/site/home-role-marketing.webp', 'images/site/home-role-developer.webp', 'images/site/home-role-reels.webp'];
    $heroImage = asset('images/site/home-hero.webp');
@endphp

@section('content')
    {{-- ─── Hero: full-bleed photo, message overlaid, wordmark across the bottom edge ─── --}}
    <section class="page-hero">
        {{-- TODO: replace with a real team photo or a muted looping showreel <video>. --}}
        <x-cinema-media :src="$heroImage" :alt="__('home.hero.image_alt')" variant="home" />

        <div class="container home-hero-content">
            <div class="home-hero-grid">
                <p class="home-hero-subtitle" data-reveal style="--d:4">
                    {{ __('home.hero.subtitle') }}
                </p>
                <div class="home-hero-actions" data-reveal style="--d:5">
                    <a href="{{ route('services') }}" class="btn btn-primary">
                        {{ __('common.cta_services') }}
                        <i class="ph ph-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-glass">{{ __('home.hero.cta_team') }}</a>
                </div>
            </div>
        </div>

        {{-- Letters rise into place on load; each sits in its own clipping box. --}}
        <h1 class="hero-wordmark" aria-label="I MUST">
            @foreach (['I', ' ', 'M', 'U', 'S', 'T'] as $letter)
                <span class="letter-clip" aria-hidden="true">
                    <span class="hero-letter" style="--i:{{ $loop->index }}">{!! $letter === ' ' ? '&nbsp;' : e($letter) !!}</span>
                </span>
            @endforeach
        </h1>
    </section>

    {{-- ─── Team: edge-to-edge photo triptych ─── --}}
    <section class="home-team">
        <div class="container home-team-head">
            <h2 class="section-heading section-heading-xl home-team-title" data-reveal>
                {{ __('home.team.title') }}
            </h2>
            <div class="home-team-aside" data-reveal style="--d:1">
                <p class="home-team-lead">{{ __('home.team.lead') }}</p>
                <a href="{{ route('about') }}" class="link-arrow mt-20">{{ __('home.team.link') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="home-team-grid">
            @foreach (__('home.team.roles') as $role)
                <a href="{{ route('about') }}" class="photo-card home-team-card" data-reveal style="--d:{{ $loop->index }}">
                    <img src="{{ asset($roleImages[$loop->index]) }}" width="687" height="1024" loading="lazy" alt="{{ $role['alt'] }}" class="photo-card-img">
                    <div class="photo-card-shade" aria-hidden="true"></div>

                    <span class="glass-pill arrow-badge" aria-hidden="true">
                        <i class="ph ph-arrow-right"></i>
                    </span>

                    <h3 class="home-team-card-title">{{ $role['title'] }}</h3>
                    <p class="home-team-card-text">{{ $role['text'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ─── Packages: flat pricing cards (shared with the services page) ─── --}}
    <section class="home-packages">
        <div class="container">
            <div class="section-head home-packages-head" data-reveal>
                <h2 class="section-heading section-heading-xl">{{ __('home.packages.title') }}</h2>
                <a href="{{ route('services') }}" class="btn btn-glass w-fit">{{ __('common.cta_services') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
            </div>

            @include('partials.package-cards')
        </div>
    </section>

    {{-- ─── Studio: full-bleed image, title word across the bottom edge (echoes the hero) ─── --}}
    <section class="home-studio">
        <img src="{{ asset('images/site/home-studio.webp') }}" width="1024" height="572" loading="lazy" alt="{{ __('home.studio.image_alt') }}" class="home-studio-img">
        <div class="home-studio-shade" aria-hidden="true"></div>

        <div class="container home-studio-content">
            <div class="home-studio-text" data-reveal>
                <h2 class="section-heading">{{ __('home.studio.title') }}</h2>
                <p class="home-studio-lead">{{ __('home.studio.lead') }}</p>
                <a href="{{ route('expansion') }}" class="btn btn-glass mt-28">{{ __('home.studio.link') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <p class="studio-word" aria-hidden="true" data-reveal>{{ __('common.nav.expansion') }}</p>
    </section>

    {{-- ─── Closing call to action: large type ─── --}}
    <section class="home-cta">
        <div class="container home-cta-inner">
            <h2 class="home-cta-title" data-reveal>
                {{ __('home.cta.title') }}
            </h2>
            <div class="home-cta-row" data-reveal style="--d:1">
                <p class="home-cta-lead">{{ __('home.cta.lead') }}</p>
                <a href="{{ route('contact') }}" class="btn btn-primary btn-lg w-fit">
                    {{ __('common.cta_contact') }}
                    <i class="ph ph-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="home-cta-glow" aria-hidden="true"></div>
    </section>
@endsection
