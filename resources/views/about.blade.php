@extends('layouts.app')

@section('title', __('about.meta_title'))
@section('description', __('about.meta_description'))

@php
    $founders = __('about.founders.people');
    $roleIcons = ['ph-megaphone', 'ph-code', 'ph-film-slate'];

    // TODO: replace placeholder photography (picsum.photos) with real portraits and project images,
    // and '#' with real portfolio / case-study links.
    $founderLinks = ['marketing' => '#', 'development' => '#', 'video' => '#'];
    $projectSeeds = ['imust-project-website', 'imust-project-social', 'imust-project-video', 'imust-project-ads', 'imust-project-brand'];
@endphp

@section('content')
    {{-- Hero: full-bleed photo, statement and the union equation across the bottom --}}
    <section class="relative isolate flex min-h-[100dvh] flex-col justify-end overflow-hidden">
        <div class="cinema-media absolute inset-0 -z-1">
            <img src="https://picsum.photos/seed/imust-about-team/2400/1500?grayscale" width="2400" height="1500"
                 alt="{{ __('about.image_alt') }}" fetchpriority="high" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-ink/45" aria-hidden="true"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/40 to-ink/60" aria-hidden="true"></div>
        </div>

        <div class="container pb-40 pt-144 md:pb-64">
            <p class="eyebrow" data-reveal>{{ __('about.eyebrow') }}</p>
            <h1 class="mt-16 max-w-5xl text-balance text-[40px] font-bold leading-[1.02] tracking-tight md:text-[64px] xl:text-[80px]" data-reveal style="--d:1">
                {{ __('about.title') }}
            </h1>
            <p class="mt-16 max-w-[52ch] text-p text-paper/80 md:text-pm" data-reveal style="--d:2">{{ __('about.lead') }}</p>

            <div class="mt-48 border-t border-white/15 pt-28 md:mt-72 md:pt-40">
                <p class="flex flex-wrap items-baseline gap-x-14 gap-y-2 text-[34px] font-bold leading-[1.08] tracking-[-0.03em] md:gap-x-24 md:text-[60px] xl:text-[88px]">
                    @foreach ($founders as $id => $founder)
                        <a href="#{{ $id }}" class="decoration-primary decoration-[3px] underline-offset-[10px] transition-colors hover:text-primaryLight hover:underline" data-reveal style="--d:{{ 3 + $loop->index }}">{{ $founder['discipline'] }}</a>
                        <span class="text-primary" aria-hidden="true">{{ $loop->last ? '=' : '+' }}</span>
                    @endforeach
                    <span class="whitespace-nowrap text-primary" data-reveal style="--d:6">I&nbsp;MUST</span>
                </p>
                <p class="mt-16 text-ps text-paper/60">{{ __('about.equation_hint') }}</p>
            </div>
        </div>
    </section>

    {{-- Team structure: statement left, roles right --}}
    <section class="py-96 md:py-144">
        <div class="container grid gap-48 lg:grid-cols-12 lg:gap-32">
            <div class="lg:col-span-5" data-reveal>
                <h2 class="text-[34px] font-bold leading-[1.05] tracking-tight md:text-[56px]">{{ __('about.structure.title') }}</h2>
                <p class="mt-20 max-w-[44ch] text-p text-muted md:text-pm">{{ __('about.structure.lead') }}</p>
            </div>
            <ul class="flex flex-col lg:col-span-6 lg:col-start-7">
                @foreach (__('about.structure.roles') as $role)
                    <li class="flex gap-20 border-t border-white/10 py-28 last:border-b md:gap-28 md:py-36" data-reveal style="--d:{{ $loop->index }}">
                        <i class="ph-light {{ $roleIcons[$loop->index] ?? 'ph-user' }} text-[40px] leading-none text-primary" aria-hidden="true"></i>
                        <div>
                            <h3 class="text-h4 font-bold md:text-[28px]">{{ $role['title'] }}</h3>
                            <p class="mt-8 text-p text-muted md:text-pm">{{ $role['text'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Founders: tall photo cards, bio slides up on hover (always visible on touch / small screens) --}}
    <section class="pb-96 md:pb-144">
        <div class="container">
            <div class="pb-40 md:pb-56" data-reveal>
                <p class="eyebrow">{{ __('about.founders.eyebrow') }}</p>
                <h2 class="mt-16 text-[34px] font-bold leading-[1.05] tracking-tight md:text-[56px] xl:text-[72px]">{{ __('about.founders.title') }}</h2>
            </div>

            <div class="grid gap-20 md:gap-24 lg:grid-cols-3">
                @foreach ($founders as $id => $founder)
                    {{-- The #anchor target stays untransformed; only its child animates. --}}
                    <article id="{{ $id }}" class="scroll-mt-[112px]">
                        <a href="{{ $founderLinks[$id] ?? '#' }}" data-reveal style="--d:{{ $loop->index }}"
                           class="founder-card group relative isolate flex min-h-[440px] flex-col justify-end overflow-hidden rounded-[24px] border border-white/10 p-24 sm:min-h-[520px] md:p-28 lg:min-h-0 lg:aspect-[3/4.4]">
                            <img src="https://picsum.photos/seed/imust-founder-{{ $id }}/900/1200?grayscale" width="900" height="1200" loading="lazy" alt=""
                                 class="absolute inset-0 -z-1 h-full w-full object-cover transition duration-700 ease-out group-hover:scale-[1.05]">
                            <div class="absolute inset-0 -z-1 bg-gradient-to-t from-ink via-ink/50 to-ink/0" aria-hidden="true"></div>

                            <span class="glass-pill absolute right-20 top-20 grid h-48 w-48 place-items-center rounded-full transition-transform duration-300 group-hover:rotate-[-45deg]" aria-hidden="true">
                                <i class="ph ph-arrow-right text-[20px]"></i>
                            </span>

                            <p class="text-ps font-semibold text-primary">{{ $founder['discipline'] }}</p>
                            <h3 class="mt-6 text-[28px] font-bold leading-tight md:text-[32px]">{{ $founder['name'] }}</h3>
                            <p class="mt-4 text-p text-paper/80">{{ $founder['position'] }}</p>
                            <div class="founder-bio">
                                <p class="pt-16 text-p text-paper/75">{{ $founder['bio'] }}</p>
                                <p class="mt-16 text-ps font-semibold text-paper">{{ __('about.founders.view_portfolio') }}</p>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Developers and partners: smaller photo cards in the same style --}}
    <section class="pb-96 md:pb-144">
        <div class="container">
            <div class="flex flex-col justify-between gap-12 pb-32 md:flex-row md:items-end md:pb-40" data-reveal>
                <h2 class="text-[28px] font-bold leading-tight tracking-tight md:text-[40px]">{{ __('about.network.title') }}</h2>
                <p class="max-w-[44ch] text-p text-muted">{{ __('about.network.lead') }}</p>
            </div>
            <ul class="grid grid-cols-2 gap-16 md:grid-cols-4 md:gap-24">
                @foreach (__('about.network.people') as $person)
                    <li data-reveal style="--d:{{ $loop->index }}">
                        <a href="#" class="group relative isolate flex aspect-square flex-col justify-end overflow-hidden rounded-[20px] border border-white/10 p-16 md:p-20">
                            <img src="https://picsum.photos/seed/imust-network-{{ $loop->index }}/600/600?grayscale" width="600" height="600" loading="lazy" alt=""
                                 class="absolute inset-0 -z-1 h-full w-full object-cover opacity-80 transition duration-700 ease-out group-hover:scale-[1.05] group-hover:opacity-100">
                            <div class="absolute inset-0 -z-1 bg-gradient-to-t from-ink via-ink/30 to-ink/0" aria-hidden="true"></div>
                            <p class="text-ps font-semibold leading-tight sm:text-p">{{ $person['name'] }}</p>
                            <p class="text-ps text-paper/70">{{ $person['role'] }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{--
        Projects: Swiper slider. The slider sits in the page container with overflow visible,
        so the first slide lines up with the heading and the rest run off the right edge.
    --}}
    <section class="overflow-hidden pb-96 md:pb-144" data-gallery>
        <div class="container flex flex-col justify-between gap-20 pb-40 md:flex-row md:items-end md:pb-56" data-reveal>
            <div>
                <h2 class="text-[34px] font-bold leading-[1.05] tracking-tight md:text-[56px] xl:text-[72px]">{{ __('about.projects.title') }}</h2>
                <p class="mt-16 max-w-[48ch] text-p text-muted md:text-pm">{{ __('about.projects.lead') }}</p>
            </div>
            <div class="flex gap-8">
                <button type="button" data-gallery-prev class="gallery-arrow glass-pill grid h-56 w-56 place-items-center rounded-full transition-colors hover:bg-paper hover:text-ink" aria-label="{{ __('about.projects.prev') }}">
                    <i class="ph ph-arrow-left text-[20px]" aria-hidden="true"></i>
                </button>
                <button type="button" data-gallery-next class="gallery-arrow glass-pill grid h-56 w-56 place-items-center rounded-full transition-colors hover:bg-paper hover:text-ink" aria-label="{{ __('about.projects.next') }}">
                    <i class="ph ph-arrow-right text-[20px]" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <div class="container">
            <div class="swiper !overflow-visible" data-gallery-swiper>
                <ul class="swiper-wrapper">
            @foreach (__('about.projects.items') as $project)
                <li class="swiper-slide !w-[80vw] sm:!w-[420px] lg:!w-[460px] xl:!w-[520px]" data-reveal style="--d:{{ min($loop->index, 3) }}">
                    <a href="#" class="group relative isolate flex aspect-[4/5] flex-col justify-end overflow-hidden rounded-[24px] border border-white/10 p-24 md:p-28">
                        <img src="https://picsum.photos/seed/{{ $projectSeeds[$loop->index] ?? 'imust-project-'.$loop->index }}/1000/1250?grayscale" width="1000" height="1250" loading="lazy" alt=""
                             class="absolute inset-0 -z-1 h-full w-full object-cover transition duration-700 ease-out group-hover:scale-[1.05]">
                        <div class="absolute inset-0 -z-1 bg-gradient-to-t from-ink via-ink/30 to-ink/0" aria-hidden="true"></div>
                        <p class="text-ps font-semibold text-primary">{{ $project['category'] }}</p>
                        <p class="mt-6 flex items-center justify-between gap-12 text-[24px] font-bold leading-tight md:text-[28px]">
                            {{ $project['title'] }}
                            <i class="ph ph-arrow-up-right text-[24px] text-paper/70 transition-transform duration-300 group-hover:-translate-y-4 group-hover:translate-x-4" aria-hidden="true"></i>
                        </p>
                    </a>
                </li>
            @endforeach
                </ul>
            </div>
        </div>
    </section>

    @include('partials.cta-band', ['title' => __('about.cta.title')])
@endsection
