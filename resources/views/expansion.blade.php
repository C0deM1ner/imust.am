@extends('layouts.app')

@section('title', __('expansion.meta_title'))
@section('description', __('expansion.meta_description'))

@php
    // TODO: replace placeholder photography (picsum.photos) with real studio images.
    $offeringMedia = [
        ['icon' => 'ph-graduation-cap', 'seed' => 'imust-studio-education'],
        ['icon' => 'ph-presentation', 'seed' => 'imust-studio-hall'],
        ['icon' => 'ph-camera', 'seed' => 'imust-studio-photozone'],
        ['icon' => 'ph-video-camera', 'seed' => 'imust-studio-production'],
    ];
@endphp

@section('content')
    {{-- Hero: full-bleed photo, title top-left, giant "Studio" word across the bottom edge --}}
    <section class="relative isolate flex min-h-[100dvh] flex-col justify-between overflow-hidden">
        <div class="cinema-media absolute inset-0 -z-1">
            <img src="https://picsum.photos/seed/imust-studio-hero/2400/1500?grayscale" width="2400" height="1500"
                 alt="{{ __('expansion.image_alt') }}" fetchpriority="high" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-ink/40" aria-hidden="true"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-ink/80 via-ink/20 to-ink/80" aria-hidden="true"></div>
        </div>

        <div class="container pt-144 md:pt-180">
            <div class="max-w-3xl">
                <p class="eyebrow" data-reveal>{{ __('expansion.eyebrow') }}</p>
                <h1 class="mt-16 text-[40px] font-bold leading-[1.02] tracking-tight md:text-[64px] xl:text-[80px]" data-reveal style="--d:1">{{ __('expansion.title') }}</h1>
                <p class="mt-16 max-w-[48ch] text-p text-paper/80 md:text-pm" data-reveal style="--d:2">{{ __('expansion.lead') }}</p>
            </div>
        </div>

        <p class="studio-word select-none whitespace-nowrap px-12 md:px-16" aria-hidden="true">{{ __('common.nav.expansion') }}</p>
    </section>

    {{--
        Offerings: full-width photo panels that stack as you scroll (CSS position: sticky).
        Each panel sticks a little lower than the previous one so the stack edges stay visible.
    --}}
    <section class="py-96 md:py-144">
        <div class="container">
            <ol class="flex flex-col gap-24 md:gap-40">
                @foreach (__('expansion.offerings') as $offering)
                    @php($media = $offeringMedia[$loop->index] ?? ['icon' => 'ph-sparkle', 'seed' => 'imust-studio-'.$loop->index])
                    <li class="sticky" style="top: calc(96px + {{ $loop->index }} * 20px)">
                        <article class="relative isolate flex min-h-[68dvh] flex-col justify-end overflow-hidden rounded-[24px] border border-white/10 bg-surface p-24 shadow-[0_-20px_60px_rgba(5,7,10,0.6)] md:min-h-[72dvh] md:p-48 xl:p-64">
                            <img src="https://picsum.photos/seed/{{ $media['seed'] }}/2000/1200?grayscale" width="2000" height="1200" loading="lazy" alt="{{ $offering['alt'] }}"
                                 class="absolute inset-0 -z-1 h-full w-full object-cover">
                            <div class="absolute inset-0 -z-1 bg-gradient-to-t from-ink via-ink/50 to-ink/10" aria-hidden="true"></div>

                            <div class="grid gap-20 md:grid-cols-12 md:items-end">
                                <div class="md:col-span-8">
                                    <i class="ph-light {{ $media['icon'] }} text-[48px] leading-none text-primary" aria-hidden="true"></i>
                                    <h2 class="mt-16 text-[32px] font-bold leading-[1.05] tracking-tight md:text-[52px] xl:text-[64px]">{{ $offering['title'] }}</h2>
                                </div>
                                <p class="text-p text-paper/80 md:col-span-4 md:text-pm">{{ $offering['text'] }}</p>
                            </div>
                        </article>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    @include('partials.cta-band', ['title' => __('expansion.cta.title'), 'lead' => __('expansion.cta.lead')])
@endsection
