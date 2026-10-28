@extends('layouts.app')

@php($shown = 0)

<x-meta :page="$content" />

@section('content')
    {{-- ─── Work: title, tag filter and project grid (components/portfolioFilter.js) ─── --}}
    <section class="portfolio-work" data-portfolio>
        <div class="container">
            @include('partials.page-intro', ['eyebrow' => $content->hero_eyebrow, 'title' => $content->hero_title, 'lead' => $content->hero_lead])

            <nav class="portfolio-filter" aria-label="{{ __('portfolio.filter_label') }}" data-reveal style="--d:3">
                @foreach ($filters as $key => [$label, $count])
                    @php($isActive = $key === $active)
                    <a href="{{ route('portfolio.index', $key === 'all' ? [] : ['tag' => $key]) }}" data-filter="{{ $key }}"
                       @class(['filter-pill', 'is-active' => $isActive]) @if ($isActive) aria-current="true" @endif>
                        {{ $label }}
                        <span class="filter-pill-count">{{ $count }}</span>
                    </a>
                @endforeach
            </nav>

            <ul class="portfolio-grid" data-portfolio-grid>
                @foreach ($projects as $project)
                    @php($visible = $active === 'all' || $project->tags->contains('slug', $active))
                    <li data-tags="{{ $project->tags->pluck('slug')->implode(' ') }}" data-fade style="--d:{{ $visible ? $shown++ % 3 : 0 }}" @unless ($visible) hidden @endunless>
                        @include('portfolio.partials.card', ['project' => $project])
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    @include('partials.cta-band', ['title' => $content->cta_title, 'lead' => $content->cta_lead])
@endsection
