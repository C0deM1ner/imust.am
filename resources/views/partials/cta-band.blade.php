{{-- Closing call to action shared by the inner pages. Expects $title and optional $lead. --}}
<section class="py-80 md:py-120">
    <div class="container">
        <div class="relative overflow-hidden rounded-card bg-primary px-28 py-48 text-ink md:px-64 md:py-72" data-reveal>
            <div class="grid gap-32 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-8">
                    <h2 class="text-[30px] font-bold leading-tight tracking-tight md:text-[48px]">{{ $title }}</h2>
                    @isset($lead)
                        <p class="mt-16 max-w-[52ch] text-pm-mobile text-ink/75 md:text-pm">{{ $lead }}</p>
                    @endisset
                </div>
                <div class="lg:col-span-4 lg:flex lg:justify-end">
                    <a href="{{ route('contact') }}" class="btn bg-ink text-paper hover:bg-surface">
                        {{ __('common.cta_contact') }}
                        <i class="ph ph-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
