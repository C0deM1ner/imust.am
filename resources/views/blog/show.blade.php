@extends('layouts.app')

@php
    $post = __("blog.posts.{$slug}");
    $others = array_values(array_filter(array_keys(config('blog.posts')), fn ($key) => $key !== $slug));
    $url = route('blog.show', ['slug' => $slug]);
    $shareLinks = [
        'facebook' => 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($url),
        'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url='.urlencode($url),
        'telegram' => 'https://t.me/share/url?url='.urlencode($url).'&text='.urlencode($post['title']),
    ];
@endphp

@section('title', $post['title'])
@section('description', $post['excerpt'])

@section('content')
    {{-- Hero: full-bleed cover, title and meta at the bottom --}}
    <section class="relative isolate flex min-h-[80dvh] flex-col justify-end overflow-hidden md:min-h-[88dvh]">
        <div class="cinema-media absolute inset-0 -z-1">
            <img src="https://picsum.photos/seed/{{ config("blog.posts.{$slug}.cover") }}/2400/1500?grayscale" width="2400" height="1500"
                 alt="" fetchpriority="high" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-ink/45" aria-hidden="true"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/40 to-ink/60" aria-hidden="true"></div>
        </div>

        <div class="container pb-48 pt-144 md:pb-72">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-8 text-ps font-semibold text-paper/80 transition-colors hover:text-paper" data-reveal>
                <i class="ph ph-arrow-left" aria-hidden="true"></i>
                {{ __('blog.back') }}
            </a>
            <p class="mt-28 text-ps font-semibold text-primary" data-reveal style="--d:1">{{ $post['category'] }}</p>
            <h1 class="mt-12 max-w-5xl text-balance text-[36px] font-bold leading-[1.05] tracking-tight md:text-[56px] xl:text-[68px]" data-reveal style="--d:2">{{ $post['title'] }}</h1>
            <p class="mt-20 flex flex-wrap items-center gap-x-8 gap-y-4 text-p text-paper/75" data-reveal style="--d:3">
                @include('blog.partials.meta', ['slug' => $slug])
            </p>
        </div>
    </section>

    {{-- Article with a sticky share rail on desktop --}}
    <section class="py-72 md:py-96">
        <div class="container grid gap-48 lg:grid-cols-12 lg:gap-32">
            <aside class="order-last lg:order-first lg:col-span-2">
                <div class="lg:sticky lg:top-[120px]">
                    <p class="text-ps font-semibold text-muted">{{ __('blog.share') }}</p>
                    <div class="mt-12 flex gap-8 lg:flex-col lg:items-start">
                        <button type="button" data-copy-link data-copied-label="{{ __('blog.copied') }}"
                                class="inline-flex h-44 items-center gap-8 rounded-[12px] border border-line px-14 text-ps font-semibold text-paper/85 transition-colors hover:border-muted">
                            <i class="ph ph-link-simple text-[18px]" aria-hidden="true"></i>
                            <span data-copy-label>{{ __('blog.copy_link') }}</span>
                        </button>
                        <div class="flex gap-8">
                            @foreach ($shareLinks as $network => $shareUrl)
                                <a href="{{ $shareUrl }}" target="_blank" rel="noopener" aria-label="{{ __('blog.share') }}: {{ ucfirst($network) }}"
                                   class="grid h-44 w-44 place-items-center rounded-full border border-line text-paper/80 transition-colors hover:border-primary hover:bg-primary hover:text-ink">
                                    <i class="ph ph-{{ $network }}-logo text-[20px]" aria-hidden="true"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            <article class="article-body lg:col-span-8">
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

    @if ($others)
        <section class="border-t border-line py-96 md:py-120">
            <div class="container">
                <div class="flex flex-col justify-between gap-20 pb-40 md:flex-row md:items-end md:pb-56" data-reveal>
                    <h2 class="text-[30px] font-bold leading-tight tracking-tight md:text-[44px]">{{ __('blog.more') }}</h2>
                    <a href="{{ route('blog.index') }}" class="btn btn-glass w-fit">{{ __('blog.back') }} <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
                </div>
                <ul class="grid gap-20 md:grid-cols-2 md:gap-24 lg:grid-cols-3">
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
