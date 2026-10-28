@extends('layouts.app')

@php
    $packages = App\Nova\Templates\ServicesPage::PACKAGES;
    $lineIcons = ['ph-stairs', 'ph-door-open', 'ph-tree'];
@endphp

<x-meta :page="$content" :image="$content->office_image" />

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
            <form id="contact-form" method="post" action="{{ route('contact.store') }}" data-contact-form novalidate class="contact-form" data-reveal style="--d:1">
                @csrf
                <h2 class="contact-form-title">{{ __('contact.form.title') }}</h2>

                {{-- Honeypot: hidden from people; a filled-in value marks the request as spam (StoreContactRequest). --}}
                <div class="hidden" aria-hidden="true">
                    <label for="website">Website</label>
                    <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                </div>

                <div class="contact-form-grid">
                    <div class="form-group">
                        <label for="name" class="field-label">{{ __('contact.form.name') }}</label>
                        <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" required data-validate class="field" aria-describedby="name-error" @error('name') aria-invalid="true" @enderror>
                        <p id="name-error" @class(['field-error', 'hidden' => ! $errors->has('name')])>{{ $errors->first('name') ?: __('contact.form.errors.name') }}</p>
                    </div>

                    <div class="form-group">
                        <label for="company" class="field-label">{{ __('contact.form.company') }} <span class="field-optional">({{ __('contact.form.optional') }})</span></label>
                        <input id="company" name="company" type="text" autocomplete="organization" value="{{ old('company') }}" class="field">
                    </div>

                    <div class="form-group">
                        <label for="email" class="field-label">{{ __('contact.form.email') }}</label>
                        <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required data-validate class="field" aria-describedby="email-error" @error('email') aria-invalid="true" @enderror>
                        <p id="email-error" @class(['field-error', 'hidden' => ! $errors->has('email')])>{{ $errors->first('email') ?: __('contact.form.errors.email') }}</p>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="field-label">{{ __('contact.form.phone') }} <span class="field-optional">({{ __('contact.form.optional') }})</span></label>
                        <input id="phone" name="phone" type="tel" autocomplete="tel" value="{{ old('phone') }}" class="field">
                    </div>

                    <fieldset class="contact-form-wide">
                        <legend class="field-label">{{ __('contact.form.package') }}</legend>
                        <div class="choice-group">
                            @foreach ($packages + ['unsure' => __('contact.form.package_unsure')] as $value => $label)
                                <label class="choice">
                                    <input type="radio" name="package" value="{{ $value }}" class="choice-input" @checked($value === old('package', 'unsure'))>
                                    <span class="choice-pill">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="form-group contact-form-wide">
                        <label for="message" class="field-label">{{ __('contact.form.message') }}</label>
                        <textarea id="message" name="message" rows="5" required data-validate class="field resize-y" aria-describedby="message-hint message-error" @error('message') aria-invalid="true" @enderror>{{ old('message') }}</textarea>
                        <p id="message-hint" class="field-hint">{{ __('contact.form.message_hint') }}</p>
                        <p id="message-error" @class(['field-error', 'hidden' => ! $errors->has('message')])>{{ $errors->first('message') ?: __('contact.form.errors.message') }}</p>
                    </div>
                </div>

                <button type="submit" data-form-submit class="contact-form-submit">
                    {{ __('contact.form.submit') }}
                    <i class="ph ph-paper-plane-tilt" aria-hidden="true"></i>
                </button>

                <p data-form-status data-failed="{{ __('contact.form.failed', ['email' => $email]) }}" tabindex="-1" role="status"
                   @class(['contact-form-status', 'hidden' => ! session('contact_sent')])>
                    <i class="ph ph-check-circle" aria-hidden="true"></i><span data-form-status-text>{{ __('contact.form.sent') }}</span>
                </p>
            </form>
        </div>
    </section>
@endsection
