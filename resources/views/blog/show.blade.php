@extends('layouts.app')

<x-meta
    :page="$post"
    :description="$post->excerpt"
    :image="$post->cover"
    type="article"
    :published="$post->published_at"
/>

@section('content')
    {{-- ─── Hero: full-bleed cover, title and meta at the bottom ─── --}}
    <section class="page-hero blog-post-hero">
        <x-cinema-media :src="img($post->cover)" />

        <div class="container blog-post-hero-content">
            <a href="{{ route('blog.index') }}" class="back-link" data-reveal>
                <i class="ph ph-arrow-left" aria-hidden="true"></i>
                {{ __('blog.back') }}
            </a>
            <p class="blog-post-category" data-reveal style="--d:1">{{ $post->category }}</p>
            <h1 class="blog-post-title" data-reveal style="--d:2">{{ $post->title }}</h1>
            <p class="post-meta blog-post-meta" data-reveal style="--d:3">
                @include('blog.partials.meta', ['post' => $post])
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
                <p class="lead-in">{{ $post->excerpt }}</p>
                {{-- Written in Nova's CKEditor by admins. --}}
                {!! $post->body !!}
            </article>
        </div>
    </section>

    {{-- ─── More posts ─── --}}
    @if ($others->isNotEmpty())
        <section class="blog-related">
            <div class="container">
                <div class="section-head" data-reveal>
                    <h2 class="blog-related-title">{{ __('blog.more') }}</h2>
                    <a href="{{ route('blog.index') }}" class="btn btn-glass w-fit">{{ __('blog.back') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
                </div>
                <ul class="post-grid">
                    @foreach ($others as $other)
                        <li data-fade style="--d:{{ $loop->index }}">
                            @include('blog.partials.card', ['post' => $other])
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    @include('partials.cta-band', ['title' => $listing->cta_title, 'lead' => $listing->cta_lead])
@endsection
