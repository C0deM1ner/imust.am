@extends('layouts.app')

<x-meta :page="$content" :title="__('common.meta_title')" :image="$content->hero_image" />

@section('content')
    {{-- ─── Hero: full-bleed photo, message overlaid, wordmark across the bottom edge ─── --}}
    <section class="page-hero">
        <x-cinema-media :src="img($content->hero_image)" :alt="$content->hero_image_alt" variant="home" />

        <div class="container home-hero-content">
            <div class="home-hero-grid">
                <p class="home-hero-subtitle" data-reveal style="--d:4">
                    {{ $content->hero_subtitle }}
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
                {{ $content->team_title }}
            </h2>
            <div class="home-team-aside" data-reveal style="--d:1">
                <p class="home-team-lead">{{ $content->team_lead }}</p>
                <a href="{{ route('about') }}" class="link-arrow mt-20">{{ __('home.team.link') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="home-team-grid">
            @foreach ($content->team_roles ?? [] as $role)
                @php($role = $role['attributes'])
                <a href="{{ route('about') }}" class="photo-card home-team-card" data-reveal style="--d:{{ $loop->index }}">
                    <img src="{{ img($role['image'] ?? null) }}" width="687" height="1024" loading="lazy" alt="{{ $role['image_alt'] ?? '' }}" class="photo-card-img">
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
                <h2 class="section-heading section-heading-xl">{{ $content->packages_title }}</h2>
                <a href="{{ route('services') }}" class="btn btn-glass w-fit">{{ __('common.cta_services') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
            </div>

            @include('partials.package-cards', ['services' => $services])
        </div>
    </section>

    {{-- ─── Studio: full-bleed image, title word across the bottom edge (echoes the hero) ─── --}}
    <section class="home-studio">
        <img src="{{ img($content->studio_image) }}" width="1024" height="572" loading="lazy" alt="{{ $content->studio_image_alt }}" class="home-studio-img">
        <div class="home-studio-shade" aria-hidden="true"></div>

        <div class="container home-studio-content">
            <div class="home-studio-text" data-reveal>
                <h2 class="section-heading">{{ $content->studio_title }}</h2>
                <p class="home-studio-lead">{{ $content->studio_lead }}</p>
                <a href="{{ route('expansion') }}" class="btn btn-glass mt-28">{{ __('home.studio.link') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <p class="studio-word" aria-hidden="true" data-reveal>{{ __('common.nav.expansion') }}</p>
    </section>

    {{-- ─── Closing call to action: large type ─── --}}
    <section class="home-cta">
        <div class="container home-cta-inner">
            <h2 class="home-cta-title" data-reveal>
                {{ $content->cta_title }}
            </h2>
            <div class="home-cta-row" data-reveal style="--d:1">
                <p class="home-cta-lead">{{ $content->cta_lead }}</p>
                <a href="{{ route('contact') }}" class="btn btn-primary btn-lg w-fit">
                    {{ __('common.cta_contact') }}
                    <i class="ph ph-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="home-cta-glow" aria-hidden="true"></div>
    </section>
@endsection
