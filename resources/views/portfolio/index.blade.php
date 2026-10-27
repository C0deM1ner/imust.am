@extends('layouts.app')

@section('title', __('portfolio.meta_title'))
@section('description', __('portfolio.meta_description'))

@php
    $tags = config('portfolio.tags');
    $projects = config('portfolio.projects');
    $counts = array_count_values(array_merge(...array_column($projects, 'tags')));

    // ?tag=video renders the list already filtered, so the pills work without JS too.
    $active = in_array(request('tag'), $tags, true) ? request('tag') : 'all';
    $filters = ['all' => [__('portfolio.all'), count($projects)]];
    foreach ($tags as $tag) {
        $filters[$tag] = [__("portfolio.tags.{$tag}"), $counts[$tag] ?? 0];
    }
    $shown = 0;
@endphp

@section('content')
    {{-- ─── Work: title, tag filter and project grid (components/portfolioFilter.js) ─── --}}
    <section class="portfolio-work" data-portfolio>
        <div class="container">
            @include('partials.page-intro', ['eyebrow' => __('portfolio.eyebrow'), 'title' => __('portfolio.title'), 'lead' => __('portfolio.lead')])

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
                @foreach ($projects as $slug => $project)
                    @php($visible = $active === 'all' || in_array($active, $project['tags'], true))
                    <li data-tags="{{ implode(' ', $project['tags']) }}" data-fade style="--d:{{ $visible ? $shown++ % 3 : 0 }}" @unless ($visible) hidden @endunless>
                        @include('portfolio.partials.card', ['slug' => $slug, 'project' => $project])
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    @include('partials.cta-band', ['title' => __('portfolio.cta.title'), 'lead' => __('portfolio.cta.lead')])
@endsection
