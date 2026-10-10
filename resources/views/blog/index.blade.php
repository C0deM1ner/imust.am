@extends('layouts.app')

@section('title', __('blog.meta_title'))
@section('description', __('blog.meta_description'))

@php
    $slugs = array_keys(config('blog.posts'));
    $featured = array_shift($slugs);
    $featuredPost = __("blog.posts.{$featured}");
@endphp

@section('content')
    {{-- Hero: the latest post as a full-bleed cover, page title on top, featured post panel at the bottom --}}
    <section class="relative isolate flex min-h-[100dvh] flex-col justify-between overflow-hidden">
        <div class="cinema-media absolute inset-0 -z-1">
            <img src="https://picsum.photos/seed/{{ config("blog.posts.{$featured}.cover") }}/2400/1500?grayscale" width="2400" height="1500"
                 alt="" fetchpriority="high" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-ink/45" aria-hidden="true"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-ink/80 via-ink/20 to-ink" aria-hidden="true"></div>
        </div>

        <div class="container pt-144 md:pt-180">
            <p class="eyebrow" data-reveal>{{ __('blog.eyebrow') }}</p>
            <h1 class="mt-16 max-w-4xl text-balance text-[40px] font-bold leading-[1.02] tracking-tight md:text-[64px] xl:text-[80px]" data-reveal style="--d:1">{{ __('blog.title') }}</h1>
            <p class="mt-16 max-w-[52ch] text-p text-paper/80 md:text-pm" data-reveal style="--d:2">{{ __('blog.lead') }}</p>
        </div>

        <div class="container pb-24 pt-48 md:pb-40">
            <a href="{{ route('blog.show', ['slug' => $featured]) }}" class="glass-pill group grid gap-20 rounded-[24px] p-24 md:grid-cols-12 md:items-end md:p-36" data-reveal style="--d:3">
                <div class="md:col-span-8">
                    <p class="flex flex-wrap items-center gap-x-8 gap-y-4 text-ps text-paper/70">
                        <span class="font-semibold text-primary">{{ $featuredPost['category'] }}</span>
                        <span aria-hidden="true">&middot;</span>
                        @include('blog.partials.meta', ['slug' => $featured])
                    </p>
                    <h2 class="mt-12 text-balance text-[26px] font-bold leading-tight tracking-tight transition-colors group-hover:text-primaryLight md:text-[36px]">{{ $featuredPost['title'] }}</h2>
                    <p class="mt-10 max-w-[60ch] text-p text-paper/75">{{ $featuredPost['excerpt'] }}</p>
                </div>
                <div class="md:col-span-4 md:flex md:justify-end">
                    <span class="btn bg-paper text-ink group-hover:bg-white">
                        {{ __('blog.read_article') }}
                        <i class="ph ph-arrow-right" aria-hidden="true"></i>
                    </span>
                </div>
            </a>
        </div>
    </section>

    {{-- The rest of the posts --}}
    @if ($slugs)
        <section class="py-96 md:py-144">
            <div class="container">
                <h2 class="pb-40 text-[34px] font-bold leading-[1.05] tracking-tight md:pb-56 md:text-[56px]" data-reveal>{{ __('blog.more') }}</h2>
                <ul class="grid gap-20 md:grid-cols-2 md:gap-24 lg:grid-cols-3">
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
