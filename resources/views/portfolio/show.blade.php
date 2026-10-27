@extends('layouts.app')

@php
    $projects = config('portfolio.projects');
    $project = $projects[$slug];
    $text = __("portfolio.projects.{$slug}");
    $coverUrl = isset($project['image']) ? asset($project['image']) : 'https://picsum.photos/seed/'.$project['cover'].'/2400/1500?grayscale';

    // TODO: replace with real project photos.
    $gallery = [$project['cover'].'-1', $project['cover'].'-2', $project['cover'].'-3'];

    // Projects that share a service come first.
    $others = array_diff_key($projects, [$slug => true]);
    uasort($others, fn ($a, $b) => count(array_intersect($b['tags'], $project['tags'])) <=> count(array_intersect($a['tags'], $project['tags'])));
    $others = array_slice($others, 0, 3, true);
@endphp

@section('title', $text['title'])
@section('description', $text['summary'])

@section('content')
    {{-- ─── Hero: full-bleed cover, services, title and client at the bottom ─── --}}
    <section class="page-hero project-hero">
        <x-cinema-media :src="$coverUrl" />

        <div class="container project-hero-content">
            <a href="{{ route('portfolio.index') }}" class="back-link" data-reveal>
                <i class="ph ph-arrow-left" aria-hidden="true"></i>
                {{ __('portfolio.back') }}
            </a>
            <ul class="project-hero-tags" data-reveal style="--d:1">
                @foreach ($project['tags'] as $tag)
                    <li class="glass-pill tag-pill">{{ __("portfolio.tags.{$tag}") }}</li>
                @endforeach
            </ul>
            <h1 class="project-title" data-reveal style="--d:2">{{ $text['title'] }}</h1>
            <p class="project-client" data-reveal style="--d:3">{{ $text['client'] }} &middot; {{ $project['year'] }}</p>
        </div>
    </section>

    {{-- ─── Story with a sticky facts column on desktop ─── --}}
    <section class="project-body">
        <div class="container project-grid">
            <aside class="project-facts">
                <dl class="project-facts-list">
                    <div class="project-fact">
                        <dt>{{ __('portfolio.client') }}</dt>
                        <dd>{{ $text['client'] }}</dd>
                    </div>
                    <div class="project-fact">
                        <dt>{{ __('portfolio.year') }}</dt>
                        <dd>{{ $project['year'] }}</dd>
                    </div>
                    <div class="project-fact">
                        <dt>{{ __('portfolio.services') }}</dt>
                        <dd class="project-fact-tags">
                            @foreach ($project['tags'] as $tag)
                                <a href="{{ route('portfolio.index', ['tag' => $tag]) }}" class="filter-pill">{{ __("portfolio.tags.{$tag}") }}</a>
                            @endforeach
                        </dd>
                    </div>
                </dl>
            </aside>

            <article class="article-body">
                <p class="lead-in">{{ $text['summary'] }}</p>

                <h2>{{ __('portfolio.challenge_title') }}</h2>
                <p>{{ $text['challenge'] }}</p>

                <h2>{{ __('portfolio.work_title') }}</h2>
                <ul>
                    @foreach ($text['work'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>

                <h2>{{ __('portfolio.result_title') }}</h2>
                <p>{{ $text['result'] }}</p>
            </article>
        </div>
    </section>

    {{-- ─── Gallery: one wide photo, two below ─── --}}
    <section class="project-gallery">
        <ul class="container project-gallery-grid">
            @foreach ($gallery as $seed)
                <li class="project-gallery-item" data-fade style="--d:{{ $loop->index }}">
                    <img src="https://picsum.photos/seed/{{ $seed }}/1600/1000?grayscale" width="1600" height="1000" loading="lazy" alt="">
                </li>
            @endforeach
        </ul>
    </section>

    {{-- ─── More projects ─── --}}
    <section class="project-related">
        <div class="container">
            <div class="section-head" data-reveal>
                <h2 class="project-related-title">{{ __('portfolio.more') }}</h2>
                <a href="{{ route('portfolio.index') }}" class="btn btn-glass w-fit">{{ __('portfolio.back') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
            </div>
            <ul class="portfolio-grid">
                @foreach ($others as $otherSlug => $other)
                    <li data-fade style="--d:{{ $loop->index }}">
                        @include('portfolio.partials.card', ['slug' => $otherSlug, 'project' => $other])
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    @include('partials.cta-band', ['title' => __('portfolio.cta.title'), 'lead' => __('portfolio.cta.lead')])
@endsection
