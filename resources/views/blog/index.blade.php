@extends('layouts.app')

@section('title', $content->meta_title ?: $content->title)
@section('description', $content->meta_description ?: __('common.meta_description'))

@section('content')
    <section class="blog-list">
        <div class="container">
            @include('partials.page-intro', ['eyebrow' => $content->hero_eyebrow, 'title' => $content->hero_title, 'lead' => $content->hero_lead])

            {{-- ─── Latest post: wide card ─── --}}
            @if ($latest)
                <div data-reveal style="--d:3">
                    @include('blog.partials.card', ['post' => $latest, 'featured' => true])
                </div>
            @endif

            {{-- ─── The rest of the posts ─── --}}
            @if ($posts->isNotEmpty())
                <ul class="post-grid blog-list-grid">
                    @foreach ($posts as $post)
                        <li data-fade style="--d:{{ $loop->index % 3 }}">
                            @include('blog.partials.card', ['post' => $post, 'featured' => false])
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>

    @include('partials.cta-band', ['title' => $content->cta_title, 'lead' => $content->cta_lead])
@endsection
