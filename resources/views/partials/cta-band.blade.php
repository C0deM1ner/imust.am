{{-- Closing call to action shared by the inner pages. Expects $title and optional $lead. --}}
<section class="cta-band">
    <div class="container">
        <div class="cta-band-panel" data-reveal>
            <div class="cta-band-grid">
                <div class="cta-band-text">
                    <h2 class="cta-band-title">{{ $title }}</h2>
                    @isset($lead)
                        <p class="cta-band-lead">{{ $lead }}</p>
                    @endisset
                </div>
                <div class="cta-band-action">
                    <a href="{{ route('contact') }}" class="btn btn-dark">
                        {{ __('common.cta_contact') }}
                        <i class="ph ph-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
