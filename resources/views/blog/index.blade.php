@extends('layouts.app')

@section('title', __('blog.meta_title'))
@section('description', __('blog.meta_description'))

@php
    $slugs = array_keys(config('blog.posts'));
    $latest = array_shift($slugs);
@endphp

@section('content')
    <section class="blog-list">
        <div class="container">
            @include('partials.page-intro', ['eyebrow' => __('blog.eyebrow'), 'title' => __('blog.title'), 'lead' => __('blog.lead')])

            {{-- ─── Latest post: wide card ─── --}}
            <div data-reveal style="--d:3">
                @include('blog.partials.card', ['slug' => $latest, 'featured' => true])
            </div>

            {{-- ─── The rest of the posts ─── --}}
            @if ($slugs)
                <ul class="post-grid blog-list-grid">
                    @foreach ($slugs as $slug)
                        <li data-fade style="--d:{{ $loop->index % 3 }}">
                            @include('blog.partials.card', ['slug' => $slug])
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>

    @include('partials.cta-band', ['title' => __('home.cta.title'), 'lead' => __('home.cta.lead')])
@endsection
