@extends('layouts.app')

@php
    $packages = App\Nova\Templates\ServicesPage::PACKAGES;
    $lineIcons = ['ph-stairs', 'ph-door-open', 'ph-tree'];
@endphp

@section('title', $content->meta_title ?: $content->title)
@section('description', $content->meta_description ?: __('common.meta_description'))

@section('content')
    {{-- ─── Split screen: office photo with details (left), form (right). Stacks on mobile. ─── --}}
    <section class="contact-split">
        {{-- Office panel --}}
        <div class="contact-office">
            <x-cinema-media :src="img($content->office_image)" :alt="$content->office_image_alt" variant="office" width="765" height="1024" />

            <h1 class="contact-title" data-reveal>
                {{ $content->hero_title }}
            </h1>
            <p class="contact-lead" data-reveal style="--d:1">{{ $content->hero_lead }}</p>

            <div class="glass-pill contact-card" data-reveal style="--d:2">
                <div class="contact-card-grid">
                    <div>
                        <p class="contact-card-label">{{ __('contact.office.title') }}</p>
                        <address class="contact-address">
                            <span class="contact-address-city">{{ $address }}</span>
                            <ul class="contact-address-lines">
                                @foreach (lines($content->office_lines) as $line)
                                    <li>
                                        <i class="ph-light {{ $lineIcons[$loop->index] ?? 'ph-check' }}" aria-hidden="true"></i>
                                        {{ $line }}
                                    </li>
                                @endforeach
                            </ul>
                        </address>
                    </div>

                    <dl class="contact-details">
                        <div>
                            <dt>{{ __('contact.office.email') }}</dt>
                            <dd><a href="mailto:{{ $email }}">{{ $email }}</a></dd>
                        </div>
                        <div>
                            <dt>{{ __('contact.office.phone') }}</dt>
                            <dd><a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></dd>
                        </div>
                        <a href="{{ $mapUrl }}" target="_blank" rel="noopener" class="contact-map-link">
                            <i class="ph ph-map-pin" aria-hidden="true"></i>
                            {{ __('contact.office.map') }}
                            <i class="ph ph-arrow-up-right" aria-hidden="true"></i>
                        </a>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Form panel. UI only: validation runs in components/contactForm.js; there is no backend endpoint yet. --}}
        <div class="contact-form-panel">
            <form data-contact-form novalidate class="contact-form" data-reveal style="--d:1">
                <h2 class="contact-form-title">{{ __('contact.form.title') }}</h2>

                <div class="contact-form-grid">
                    <div class="form-group">
                        <label for="name" class="field-label">{{ __('contact.form.name') }}</label>
                        <input id="name" name="name" type="text" autocomplete="name" required data-validate class="field" aria-describedby="name-error">
                        <p id="name-error" class="field-error hidden">{{ __('contact.form.errors.name') }}</p>
                    </div>

                    <div class="form-group">
                        <label for="company" class="field-label">{{ __('contact.form.company') }} <span class="field-optional">({{ __('contact.form.optional') }})</span></label>
                        <input id="company" name="company" type="text" autocomplete="organization" class="field">
                    </div>

                    <div class="form-group">
                        <label for="email" class="field-label">{{ __('contact.form.email') }}</label>
                        <input id="email" name="email" type="email" autocomplete="email" required data-validate class="field" aria-describedby="email-error">
                        <p id="email-error" class="field-error hidden">{{ __('contact.form.errors.email') }}</p>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="field-label">{{ __('contact.form.phone') }} <span class="field-optional">({{ __('contact.form.optional') }})</span></label>
                        <input id="phone" name="phone" type="tel" autocomplete="tel" class="field">
                    </div>

                    <fieldset class="contact-form-wide">
                        <legend class="field-label">{{ __('contact.form.package') }}</legend>
                        <div class="choice-group">
                            @foreach ($packages + ['unsure' => __('contact.form.package_unsure')] as $value => $label)
                                <label class="choice">
                                    <input type="radio" name="package" value="{{ $value }}" class="choice-input" @checked($value === 'unsure')>
                                    <span class="choice-pill">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="form-group contact-form-wide">
                        <label for="message" class="field-label">{{ __('contact.form.message') }}</label>
                        <textarea id="message" name="message" rows="5" required data-validate class="field resize-y" aria-describedby="message-hint message-error"></textarea>
                        <p id="message-hint" class="field-hint">{{ __('contact.form.message_hint') }}</p>
                        <p id="message-error" class="field-error hidden">{{ __('contact.form.errors.message') }}</p>
                    </div>
                </div>

                <button type="submit" class="contact-form-submit">
                    {{ __('contact.form.submit') }}
                    <i class="ph ph-paper-plane-tilt" aria-hidden="true"></i>
                </button>

                <p data-form-status tabindex="-1" role="status" class="contact-form-status hidden">
                    <i class="ph ph-info" aria-hidden="true"></i>{{ __('contact.form.not_connected') }}
                </p>
            </form>
        </div>
    </section>
@endsection
