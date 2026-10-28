@extends('layouts.app')

@php
    $founders = array_column($content->founders ?? [], 'attributes');
    $roleIcons = ['ph-megaphone', 'ph-code', 'ph-film-slate'];

    // TODO: the founder and partner photos are AI-generated (faces hidden). Replace them with real photos in Nova.
@endphp

@section('title', $content->meta_title ?: $content->title)
@section('description', $content->meta_description ?: __('common.meta_description'))

@section('content')
    {{-- ─── Hero: full-bleed photo, statement and the union equation across the bottom ─── --}}
    <section class="page-hero">
        <x-cinema-media :src="img($content->hero_image)" :alt="$content->hero_image_alt" />

        <div class="container about-hero-content">
            <p class="eyebrow" data-reveal>{{ $content->hero_eyebrow }}</p>
            <h1 class="hero-title max-w-5xl" data-reveal style="--d:1">
                {{ $content->hero_title }}
            </h1>
            <p class="hero-lead" data-reveal style="--d:2">{{ $content->hero_lead }}</p>

            <div class="about-equation">
                <p class="about-equation-line">
                    @foreach ($founders as $founder)
                        <a href="#founder-{{ $loop->iteration }}" class="about-equation-term" data-reveal style="--d:{{ 3 + $loop->index }}">{{ $founder['discipline'] }}</a>
                        <span class="text-primary" aria-hidden="true">{{ $loop->last ? '=' : '+' }}</span>
                    @endforeach
                    <span class="about-equation-result" data-reveal style="--d:6">I&nbsp;MUST</span>
                </p>
                <p class="about-equation-hint">{{ $content->equation_hint }}</p>
            </div>
        </div>
    </section>

    {{-- ─── Team structure: statement left, roles right ─── --}}
    <section class="about-structure">
        <div class="container about-structure-grid">
            <div class="about-structure-intro" data-reveal>
                <h2 class="section-heading">{{ $content->structure_title }}</h2>
                <p class="about-structure-lead">{{ $content->structure_lead }}</p>
            </div>
            <ul class="about-roles">
                @foreach (array_column($content->structure_roles ?? [], 'attributes') as $role)
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
                <p class="eyebrow">{{ $content->founders_eyebrow }}</p>
                <h2 class="section-heading section-heading-xl mt-16">{{ $content->founders_title }}</h2>
            </div>

            <div class="about-founders-grid">
                @foreach ($founders as $founder)
                    <article id="founder-{{ $loop->iteration }}" class="about-founder">
                        <a href="{{ $founder['link'] ?? '#' ?: '#' }}" class="photo-card founder-card" data-reveal style="--d:{{ $loop->index }}">
                            @if ($photo = img($founder['photo'] ?? null))
                                <img src="{{ $photo }}" width="765" height="1024" loading="lazy" alt="" class="photo-card-img">
                            @endif
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
                <h2 class="about-network-title">{{ $content->network_title }}</h2>
                <p class="about-network-lead">{{ $content->network_lead }}</p>
            </div>
            <ul class="about-network-grid">
                @foreach (array_column($content->network_people ?? [], 'attributes') as $person)
                    <li data-reveal style="--d:{{ $loop->index }}">
                        <a href="{{ $person['link'] ?? '#' ?: '#' }}" class="photo-card network-card">
                            @if ($photo = img($person['photo'] ?? null))
                                <img src="{{ $photo }}" width="1024" height="1024" loading="lazy" alt="" class="photo-card-img">
                            @endif
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
                <h2 class="section-heading section-heading-xl">{{ $content->projects_title }}</h2>
                <p class="about-projects-lead">{{ $content->projects_lead }}</p>
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
                    @foreach ($projects as $project)
                        <li class="swiper-slide project-slide" data-reveal style="--d:{{ min($loop->index, 3) }}">
                            <a href="{{ route('portfolio.show', $project) }}" class="photo-card project-card">
                                <img src="{{ img($project->cover) }}" width="1024" height="687" loading="lazy" alt="" class="photo-card-img">
                                <div class="photo-card-shade" aria-hidden="true"></div>
                                <p class="project-card-category">{{ $project->tags->first()?->name }}</p>
                                <p class="project-card-title">
                                    {{ $project->title }}
                                    <i class="ph ph-arrow-up-right" aria-hidden="true"></i>
                                </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    @include('partials.cta-band', ['title' => $content->cta_title])
@endsection
