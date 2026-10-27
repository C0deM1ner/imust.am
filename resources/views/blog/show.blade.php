@extends('layouts.app')

@php
    $post = __("blog.posts.{$slug}");
    $others = array_values(array_filter(array_keys(config('blog.posts')), fn ($key) => $key !== $slug));
    $url = route('blog.show', ['slug' => $slug]);
    $coverUrl = asset(config("blog.posts.{$slug}.image"));
    $shareLinks = [
        'facebook' => 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($url),
        'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url='.urlencode($url),
        'telegram' => 'https://t.me/share/url?url='.urlencode($url).'&text='.urlencode($post['title']),
    ];
@endphp

@section('title', $post['title'])
@section('description', $post['excerpt'])

@section('content')
    {{-- ─── Hero: full-bleed cover, title and meta at the bottom ─── --}}
    <section class="page-hero blog-post-hero">
        <x-cinema-media :src="$coverUrl" />

        <div class="container blog-post-hero-content">
            <a href="{{ route('blog.index') }}" class="back-link" data-reveal>
                <i class="ph ph-arrow-left" aria-hidden="true"></i>
                {{ __('blog.back') }}
            </a>
            <p class="blog-post-category" data-reveal style="--d:1">{{ $post['category'] }}</p>
            <h1 class="blog-post-title" data-reveal style="--d:2">{{ $post['title'] }}</h1>
            <p class="post-meta blog-post-meta" data-reveal style="--d:3">
                @include('blog.partials.meta', ['slug' => $slug])
            </p>
        </div>
    </section>

    {{-- ─── Article with a sticky share rail on desktop ─── --}}
    <section class="blog-post-body">
        <div class="container blog-post-grid">
            <aside class="share-rail">
                <div class="share-rail-inner">
                    <p class="share-rail-label">{{ __('blog.share') }}</p>
                    <div class="share-rail-actions">
                        <button type="button" data-copy-link data-copied-label="{{ __('blog.copied') }}" class="share-copy">
                            <i class="ph ph-link-simple" aria-hidden="true"></i>
                            <span data-copy-label>{{ __('blog.copy_link') }}</span>
                        </button>
                        <div class="share-rail-links">
                            @foreach ($shareLinks as $network => $shareUrl)
                                <a href="{{ $shareUrl }}" target="_blank" rel="noopener" class="icon-link" aria-label="{{ __('blog.share') }}: {{ ucfirst($network) }}">
                                    <i class="ph ph-{{ $network }}-logo" aria-hidden="true"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            <article class="article-body">
                <p class="lead-in">{{ $post['excerpt'] }}</p>
                @foreach ($post['body'] as [$type, $content])
                    @switch($type)
                        @case('h2')
                            <h2>{{ $content }}</h2>
                            @break
                        @case('ul')
                            <ul>
                                @foreach ($content as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                            @break
                        @case('quote')
                            <blockquote>{{ $content }}</blockquote>
                            @break
                        @default
                            <p>{{ $content }}</p>
                    @endswitch
                @endforeach
            </article>
        </div>
    </section>

    {{-- ─── More posts ─── --}}
    @if ($others)
        <section class="blog-related">
            <div class="container">
                <div class="section-head" data-reveal>
                    <h2 class="blog-related-title">{{ __('blog.more') }}</h2>
                    <a href="{{ route('blog.index') }}" class="btn btn-glass w-fit">{{ __('blog.back') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
                </div>
                <ul class="post-grid">
                    @foreach (array_slice($others, 0, 3) as $other)
                        <li data-fade style="--d:{{ $loop->index }}">
                            @include('blog.partials.card', ['slug' => $other])
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    @include('partials.cta-band', ['title' => __('home.cta.title'), 'lead' => __('home.cta.lead')])
@endsection
