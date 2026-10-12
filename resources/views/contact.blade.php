@extends('layouts.app')

@section('title', __('contact.meta_title'))
@section('description', __('contact.meta_description'))

@php
    $email = config('app.contact.email');
    $phone = config('app.contact.phone');
    $packages = ['start' => 'Start', 'grow' => 'Grow', 'maintain' => 'Maintain'];
    $mapUrl = 'https://www.google.com/maps/search/?api=1&query='.urlencode('Avan, Yerevan, Armenia');
    $lineIcons = ['ph-stairs', 'ph-door-open', 'ph-tree'];
@endphp

@section('content')
    {{-- Split screen: office photo with details (left), form (right). Stacks on mobile. --}}
    <section class="grid grid-cols-1 gap-12 p-12 md:gap-16 md:p-16 lg:min-h-[100dvh] lg:grid-cols-2">
        {{-- Office panel --}}
        <div class="relative isolate flex min-h-[80dvh] flex-col justify-end overflow-hidden rounded-[28px] p-24 pt-120 md:p-40 md:pt-144 lg:min-h-0 xl:p-56">
            <div class="cinema-media absolute inset-0 -z-1">
                {{-- TODO: replace with a photo of the office entrance in Avan. --}}
                <img src="https://picsum.photos/seed/imust-office-avan/1400/1800?grayscale" width="1400" height="1800"
                     alt="{{ __('contact.office.image_alt') }}" fetchpriority="high" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-ink/40" aria-hidden="true"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/50 to-ink/30" aria-hidden="true"></div>
            </div>

            <h1 class="max-w-[14ch] text-balance text-[40px] font-bold leading-[1.02] tracking-tight md:text-[64px] xl:text-[76px]" data-reveal>
                {{ __('contact.title') }}
            </h1>
            <p class="mt-16 max-w-[40ch] text-p text-paper/80 md:text-pm" data-reveal style="--d:1">{{ __('contact.lead') }}</p>

            <div class="glass-pill mt-32 rounded-[22px] p-20 md:mt-40 md:p-28" data-reveal style="--d:2">
                <div class="grid gap-24 sm:grid-cols-2">
                    <div>
                        <p class="text-ps font-semibold text-primary">{{ __('contact.office.title') }}</p>
                        <address class="mt-8 not-italic">
                            <span class="block text-h5 font-bold">{{ __('contact.office.city') }}</span>
                            <ul class="mt-12 flex flex-col gap-8">
                                @foreach (__('contact.office.lines') as $line)
                                    <li class="flex items-center gap-10 text-p text-paper/85">
                                        <i class="ph-light {{ $lineIcons[$loop->index] ?? 'ph-check' }} text-[20px] text-primary" aria-hidden="true"></i>
                                        {{ $line }}
                                    </li>
                                @endforeach
                            </ul>
                        </address>
                    </div>

                    <dl class="flex flex-col gap-16">
                        <div>
                            <dt class="text-ps text-paper/60">{{ __('contact.office.email') }}</dt>
                            <dd><a href="mailto:{{ $email }}" class="text-p font-semibold transition-colors hover:text-primary">{{ $email }}</a></dd>
                        </div>
                        <div>
                            <dt class="text-ps text-paper/60">{{ __('contact.office.phone') }}</dt>
                            <dd><a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="text-p font-semibold transition-colors hover:text-primary">{{ $phone }}</a></dd>
                        </div>
                        <a href="{{ $mapUrl }}" target="_blank" rel="noopener" class="inline-flex w-fit items-center gap-8 text-ps font-semibold text-paper transition-colors hover:text-primary">
                            <i class="ph ph-map-pin text-[18px]" aria-hidden="true"></i>
                            {{ __('contact.office.map') }}
                            <i class="ph ph-arrow-up-right text-[14px]" aria-hidden="true"></i>
                        </a>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Form panel. UI only: validation runs in app.js; there is no backend endpoint yet. --}}
        <div class="flex flex-col justify-center rounded-[28px] border border-white/10 bg-surface p-24 md:p-40 lg:pt-120 xl:p-56 xl:pt-120">
            <form data-contact-form novalidate class="mx-auto w-full max-w-[560px]" data-reveal style="--d:1">
                <h2 class="text-[28px] font-bold leading-tight tracking-tight md:text-[36px]">{{ __('contact.form.title') }}</h2>

                <div class="mt-32 grid gap-20 sm:grid-cols-2">
                    <div class="flex flex-col gap-8">
                        <label for="name" class="field-label">{{ __('contact.form.name') }}</label>
                        <input id="name" name="name" type="text" autocomplete="name" required data-validate class="field" aria-describedby="name-error">
                        <p id="name-error" class="field-error hidden">{{ __('contact.form.errors.name') }}</p>
                    </div>

                    <div class="flex flex-col gap-8">
                        <label for="company" class="field-label">{{ __('contact.form.company') }} <span class="font-normal text-muted">({{ __('contact.form.optional') }})</span></label>
                        <input id="company" name="company" type="text" autocomplete="organization" class="field">
                    </div>

                    <div class="flex flex-col gap-8">
                        <label for="email" class="field-label">{{ __('contact.form.email') }}</label>
                        <input id="email" name="email" type="email" autocomplete="email" required data-validate class="field" aria-describedby="email-error">
                        <p id="email-error" class="field-error hidden">{{ __('contact.form.errors.email') }}</p>
                    </div>

                    <div class="flex flex-col gap-8">
                        <label for="phone" class="field-label">{{ __('contact.form.phone') }} <span class="font-normal text-muted">({{ __('contact.form.optional') }})</span></label>
                        <input id="phone" name="phone" type="tel" autocomplete="tel" class="field">
                    </div>

                    <fieldset class="sm:col-span-2">
                        <legend class="field-label">{{ __('contact.form.package') }}</legend>
                        <div class="mt-8 flex flex-wrap gap-8">
                            @foreach ($packages + ['unsure' => __('contact.form.package_unsure')] as $value => $label)
                                <label class="cursor-pointer">
                                    <input type="radio" name="package" value="{{ $value }}" class="peer sr-only" @checked($value === 'unsure')>
                                    <span class="inline-flex h-44 items-center rounded-[12px] border border-line px-16 text-ps font-semibold text-paper/80 transition-colors hover:border-muted peer-checked:border-paper peer-checked:bg-paper peer-checked:text-ink peer-focus-visible:ring-2 peer-focus-visible:ring-primary peer-focus-visible:ring-offset-2 peer-focus-visible:ring-offset-surface">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="flex flex-col gap-8 sm:col-span-2">
                        <label for="message" class="field-label">{{ __('contact.form.message') }}</label>
                        <textarea id="message" name="message" rows="5" required data-validate class="field resize-y" aria-describedby="message-hint message-error"></textarea>
                        <p id="message-hint" class="text-ps text-muted">{{ __('contact.form.message_hint') }}</p>
                        <p id="message-error" class="field-error hidden">{{ __('contact.form.errors.message') }}</p>
                    </div>
                </div>

                <button type="submit" class="mt-28 flex h-52 w-full items-center justify-center gap-10 rounded-[14px] bg-paper text-p font-semibold text-ink transition-colors hover:bg-white active:scale-[0.99]">
                    {{ __('contact.form.submit') }}
                    <i class="ph ph-paper-plane-tilt" aria-hidden="true"></i>
                </button>

                <p data-form-status tabindex="-1" role="status" class="mt-20 hidden rounded-[14px] border border-line bg-ink/60 p-16 text-ps text-paper">
                    <i class="ph ph-info mr-6 text-primary" aria-hidden="true"></i>{{ __('contact.form.not_connected') }}
                </p>
            </form>
        </div>
    </section>
@endsection
