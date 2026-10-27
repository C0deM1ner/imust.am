@extends('layouts.app')

@section('title', __('about.meta_title'))
@section('description', __('about.meta_description'))

@php
    $founders = __('about.founders.people');
    $roleIcons = ['ph-megaphone', 'ph-code', 'ph-film-slate'];

    // TODO: replace placeholder photography (picsum.photos) with real portraits and project images,
    // and '#' with real portfolio / case-study links.
    $founderLinks = ['marketing' => '#', 'development' => '#', 'video' => '#'];
    $projectSeeds = ['imust-project-website', 'imust-project-social', 'imust-project-video', 'imust-project-ads', 'imust-project-brand'];
@endphp

@section('content')
    {{-- ─── Hero: full-bleed photo, statement and the union equation across the bottom ─── --}}
    <section class="page-hero">
        <x-cinema-media src="https://picsum.photos/seed/imust-about-team/2400/1500?grayscale" :alt="__('about.image_alt')" />

        <div class="container about-hero-content">
            <p class="eyebrow" data-reveal>{{ __('about.eyebrow') }}</p>
            <h1 class="hero-title max-w-5xl" data-reveal style="--d:1">
                {{ __('about.title') }}
            </h1>
            <p class="hero-lead" data-reveal style="--d:2">{{ __('about.lead') }}</p>

            <div class="about-equation">
                <p class="about-equation-line">
                    @foreach ($founders as $id => $founder)
                        <a href="#{{ $id }}" class="about-equation-term" data-reveal style="--d:{{ 3 + $loop->index }}">{{ $founder['discipline'] }}</a>
                        <span class="text-primary" aria-hidden="true">{{ $loop->last ? '=' : '+' }}</span>
                    @endforeach
                    <span class="about-equation-result" data-reveal style="--d:6">I&nbsp;MUST</span>
                </p>
                <p class="about-equation-hint">{{ __('about.equation_hint') }}</p>
            </div>
        </div>
    </section>

    {{-- ─── Team structure: statement left, roles right ─── --}}
    <section class="about-structure">
        <div class="container about-structure-grid">
            <div class="about-structure-intro" data-reveal>
                <h2 class="section-heading">{{ __('about.structure.title') }}</h2>
                <p class="about-structure-lead">{{ __('about.structure.lead') }}</p>
            </div>
            <ul class="about-roles">
                @foreach (__('about.structure.roles') as $role)
                    <li class="about-role" data-reveal style="--d:{{ $loop->index }}">
                        <i class="ph-light {{ $roleIcons[$loop->index] ?? 'ph-user' }} about-role-icon" aria-hidden="true"></i>
                        <div>
                            <h3 class="about-role-title">{{ $role['title'] }}</h3>
                            <p class="about-role-text">{{ $role['text'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- ─── Founders: tall photo cards, bio slides up on hover (always visible on touch / small screens) ─── --}}
    <section class="about-founders">
        <div class="container">
            <div class="about-founders-head" data-reveal>
                <p class="eyebrow">{{ __('about.founders.eyebrow') }}</p>
                <h2 class="section-heading section-heading-xl mt-16">{{ __('about.founders.title') }}</h2>
            </div>

            <div class="about-founders-grid">
                @foreach ($founders as $id => $founder)
                    <article id="{{ $id }}" class="about-founder">
                        <a href="{{ $founderLinks[$id] ?? '#' }}" class="photo-card founder-card" data-reveal style="--d:{{ $loop->index }}">
                            <img src="https://picsum.photos/seed/imust-founder-{{ $id }}/900/1200?grayscale" width="900" height="1200" loading="lazy" alt="" class="photo-card-img">
                            <div class="photo-card-shade" aria-hidden="true"></div>

                            <span class="glass-pill arrow-badge" aria-hidden="true">
                                <i class="ph ph-arrow-right"></i>
                            </span>

                            <p class="founder-card-discipline">{{ $founder['discipline'] }}</p>
                            <h3 class="founder-card-name">{{ $founder['name'] }}</h3>
                            <p class="founder-card-position">{{ $founder['position'] }}</p>
                            <div class="founder-bio">
                                <p class="founder-bio-text">{{ $founder['bio'] }}</p>
                                <p class="founder-bio-link">{{ __('about.founders.view_portfolio') }}</p>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── Developers and partners: smaller photo cards in the same style ─── --}}
    <section class="about-network">
        <div class="container">
            <div class="section-head about-network-head" data-reveal>
                <h2 class="about-network-title">{{ __('about.network.title') }}</h2>
                <p class="about-network-lead">{{ __('about.network.lead') }}</p>
            </div>
            <ul class="about-network-grid">
                @foreach (__('about.network.people') as $person)
                    <li data-reveal style="--d:{{ $loop->index }}">
                        <a href="#" class="photo-card network-card">
                            <img src="https://picsum.photos/seed/imust-network-{{ $loop->index }}/600/600?grayscale" width="600" height="600" loading="lazy" alt="" class="photo-card-img">
                            <div class="photo-card-shade" aria-hidden="true"></div>
                            <p class="network-card-name">{{ $person['name'] }}</p>
                            <p class="network-card-role">{{ $person['role'] }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- ─── Projects: Swiper slider (components/gallery.js) ─── --}}
    <section class="about-projects" data-gallery>
        <div class="container section-head" data-reveal>
            <div>
                <h2 class="section-heading section-heading-xl">{{ __('about.projects.title') }}</h2>
                <p class="about-projects-lead">{{ __('about.projects.lead') }}</p>
            </div>
            <div class="gallery-arrows">
                <button type="button" data-gallery-prev class="glass-pill gallery-arrow" aria-label="{{ __('about.projects.prev') }}">
                    <i class="ph ph-arrow-left" aria-hidden="true"></i>
                </button>
                <button type="button" data-gallery-next class="glass-pill gallery-arrow" aria-label="{{ __('about.projects.next') }}">
                    <i class="ph ph-arrow-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <div class="container">
            <div class="swiper" data-gallery-swiper>
                <ul class="swiper-wrapper">
                    @foreach (__('about.projects.items') as $project)
                        <li class="swiper-slide project-slide" data-reveal style="--d:{{ min($loop->index, 3) }}">
                            <a href="#" class="photo-card project-card">
                                <img src="https://picsum.photos/seed/{{ $projectSeeds[$loop->index] ?? 'imust-project-'.$loop->index }}/1000/1250?grayscale" width="1000" height="1250" loading="lazy" alt="" class="photo-card-img">
                                <div class="photo-card-shade" aria-hidden="true"></div>
                                <p class="project-card-category">{{ $project['category'] }}</p>
                                <p class="project-card-title">
                                    {{ $project['title'] }}
                                    <i class="ph ph-arrow-up-right" aria-hidden="true"></i>
                                </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    @include('partials.cta-band', ['title' => __('about.cta.title')])
@endsection
