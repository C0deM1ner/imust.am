@extends('layouts.app')

@section('title', __('blog.meta_title'))
@section('description', __('blog.meta_description'))

@php
    $slugs = array_keys(config('blog.posts'));
    $featured = array_shift($slugs);
    $featuredPost = __("blog.posts.{$featured}");
    $coverUrl = 'https://picsum.photos/seed/'.config("blog.posts.{$featured}.cover").'/2400/1500?grayscale';
@endphp

@section('content')
    {{-- ─── Hero: the latest post as a full-bleed cover, page title on top, featured post panel at the bottom ─── --}}
    <section class="page-hero page-hero-split">
        <x-cinema-media :src="$coverUrl" variant="page" />

        <div class="container page-hero-top">
            <p class="eyebrow" data-reveal>{{ __('blog.eyebrow') }}</p>
            <h1 class="hero-title max-w-4xl" data-reveal style="--d:1">{{ __('blog.title') }}</h1>
            <p class="hero-lead" data-reveal style="--d:2">{{ __('blog.lead') }}</p>
        </div>

        <div class="container blog-featured-wrap">
            <a href="{{ route('blog.show', ['slug' => $featured]) }}" class="glass-pill blog-featured" data-reveal style="--d:3">
                <div class="blog-featured-text">
                    <p class="post-meta">
                        <span class="post-meta-category">{{ $featuredPost['category'] }}</span>
                        <span aria-hidden="true">&middot;</span>
                        @include('blog.partials.meta', ['slug' => $featured])
                    </p>
                    <h2 class="blog-featured-title">{{ $featuredPost['title'] }}</h2>
                    <p class="blog-featured-excerpt">{{ $featuredPost['excerpt'] }}</p>
                </div>
                <div class="blog-featured-action">
                    <span class="btn btn-light">
                        {{ __('blog.read_article') }}
                        <i class="ph ph-arrow-right" aria-hidden="true"></i>
                    </span>
                </div>
            </a>
        </div>
    </section>

    {{-- ─── The rest of the posts ─── --}}
    @if ($slugs)
        <section class="blog-more">
            <div class="container">
                <h2 class="section-heading blog-more-title" data-reveal>{{ __('blog.more') }}</h2>
                <ul class="post-grid">
                    @foreach ($slugs as $slug)
                        <li data-fade style="--d:{{ $loop->index % 3 }}">
                            @include('blog.partials.card', ['slug' => $slug])
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    @include('partials.cta-band', ['title' => __('home.cta.title'), 'lead' => __('home.cta.lead')])
@endsection
