@extends('layouts.app')

@section('title', $project->meta_title ?: $project->title)
@section('description', $project->meta_description ?: $project->summary)

@section('content')
    {{-- ─── Hero: full-bleed cover, services, title and client at the bottom ─── --}}
    <section class="page-hero project-hero">
        <x-cinema-media :src="img($project->cover)" />

        <div class="container project-hero-content">
            <a href="{{ route('portfolio.index') }}" class="back-link" data-reveal>
                <i class="ph ph-arrow-left" aria-hidden="true"></i>
                {{ __('portfolio.back') }}
            </a>
            <ul class="project-hero-tags" data-reveal style="--d:1">
                @foreach ($project->tags as $tag)
                    <li class="glass-pill tag-pill">{{ $tag->name }}</li>
                @endforeach
            </ul>
            <h1 class="project-title" data-reveal style="--d:2">{{ $project->title }}</h1>
            <p class="project-client" data-reveal style="--d:3">{{ $project->client }} &middot; {{ $project->year }}</p>
        </div>
    </section>

    {{-- ─── Story with a sticky facts column on desktop ─── --}}
    <section class="project-body">
        <div class="container project-grid">
            <aside class="project-facts">
                <dl class="project-facts-list">
                    <div class="project-fact">
                        <dt>{{ __('portfolio.client') }}</dt>
                        <dd>{{ $project->client }}</dd>
                    </div>
                    <div class="project-fact">
                        <dt>{{ __('portfolio.year') }}</dt>
                        <dd>{{ $project->year }}</dd>
                    </div>
                    <div class="project-fact">
                        <dt>{{ __('portfolio.services') }}</dt>
                        <dd class="project-fact-tags">
                            @foreach ($project->tags as $tag)
                                <a href="{{ route('portfolio.index', ['tag' => $tag->slug]) }}" class="filter-pill">{{ $tag->name }}</a>
                            @endforeach
                        </dd>
                    </div>
                </dl>
            </aside>

            <article class="article-body">
                <p class="lead-in">{{ $project->summary }}</p>

                @if ($project->challenge)
                    <h2>{{ __('portfolio.challenge_title') }}</h2>
                    <p>{{ $project->challenge }}</p>
                @endif

                @if ($work = lines($project->work))
                    <h2>{{ __('portfolio.work_title') }}</h2>
                    <ul>
                        @foreach ($work as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @endif

                @if ($project->result)
                    <h2>{{ __('portfolio.result_title') }}</h2>
                    <p>{{ $project->result }}</p>
                @endif
            </article>
        </div>
    </section>

    {{-- ─── Gallery: the first photo full width, the rest two per row ─── --}}
    @if ($project->gallery?->isNotEmpty())
        <section class="project-gallery">
            <ul class="container project-gallery-grid">
                @foreach ($project->gallery as $photo)
                    <li class="project-gallery-item" data-fade style="--d:{{ min($loop->index, 3) }}">
                        <img src="{{ img($photo) }}" width="1600" height="1000" loading="lazy" alt="">
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    {{-- ─── More projects ─── --}}
    <section class="project-related">
        <div class="container">
            <div class="section-head" data-reveal>
                <h2 class="project-related-title">{{ __('portfolio.more') }}</h2>
                <a href="{{ route('portfolio.index') }}" class="btn btn-glass w-fit">{{ __('portfolio.back') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
            </div>
            <ul class="portfolio-grid">
                @foreach ($others as $other)
                    <li data-fade style="--d:{{ $loop->index }}">
                        @include('portfolio.partials.card', ['project' => $other])
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    @include('partials.cta-band', ['title' => $listing->cta_title, 'lead' => $listing->cta_lead])
@endsection
