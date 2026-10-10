@php
    // Shared pricing cards (home + services). Text comes from lang/{locale}/services.php.
    // $showDetails: link each card to its section on the services page (off on the services page itself).
    $showDetails = $showDetails ?? true;
    $packageTiers = ['start' => 'Start', 'grow' => 'Grow', 'maintain' => 'Maintain'];
    $packageIcons = ['start' => 'ph-rocket-launch', 'grow' => 'ph-trend-up', 'maintain' => 'ph-shield-check'];
@endphp

{{-- Each card is a 2-row subgrid so the top sections and dividers line up across cards. --}}
<div class="mx-auto grid max-w-xl gap-20 lg:max-w-none lg:grid-cols-3 lg:grid-rows-[auto_auto] lg:gap-24">
    @foreach ($packageTiers as $key => $tier)
        @php
            $copy = __("services.items.{$key}");
        @endphp
        <article id="{{ $key }}" data-fade style="--d:{{ $loop->index }}"
                 class="price-card grid scroll-mt-[128px] overflow-hidden rounded-[24px] border border-white/20 bg-surface lg:row-span-2 lg:grid-rows-subgrid">
            <div class="flex flex-col p-28 md:p-36">
                <i class="ph-light {{ $packageIcons[$key] }} text-[56px] leading-none text-paper" aria-hidden="true"></i>

                <h3 class="mt-28 text-[28px] font-semibold leading-tight">
                    <span class="sr-only">I MUST </span>{{ $tier }}
                </h3>
                <p class="mt-4 text-p text-muted md:text-pm">{{ $copy['summary'] }}</p>

                <div class="mt-28 flex flex-wrap items-end gap-x-12 gap-y-4">
                    <span class="text-[32px] font-semibold leading-none tracking-tight md:text-[36px]">{{ $copy['price'] }}</span>
                    <span class="pb-2 text-ps leading-snug text-muted">
                        {{ $copy['cadence'] }}@if ($copy['price_note'])<br>{{ $copy['price_note'] }}@endif
                    </span>
                </div>

                <div class="mt-28 flex gap-12 rounded-[14px] border border-line bg-ink/60 p-16">
                    <i class="ph-light ph-info mt-2 text-[20px] text-paper/80" aria-hidden="true"></i>
                    <p class="text-ps text-paper/85">{{ $copy['description'] }}</p>
                </div>

                <div class="mt-auto pt-28">
                <a href="{{ route('contact') }}"
                   class="flex h-52 items-center justify-center rounded-[14px] bg-paper text-p font-semibold text-ink transition-colors hover:bg-white active:scale-[0.99]">
                    {{ __('common.cta_contact') }}
                </a>
                @if ($showDetails)
                    <a href="{{ route('services') }}#{{ $key }}" class="mt-12 block text-center text-ps text-muted underline-offset-4 transition-colors hover:text-paper hover:underline">
                        {{ __('home.packages.details') }}
                    </a>
                @endif
                </div>
            </div>

            <div class="border-t border-line p-28 md:p-36">
                <p class="text-p text-paper/90">{{ __('home.packages.included') }}</p>
                <div class="mt-12 flex flex-col gap-16">
                    @foreach ($copy['groups'] as $group => $features)
                        <div>
                            @if (count($copy['groups']) > 1)
                                <p class="mb-6 text-ps font-semibold text-muted">{{ $group }}</p>
                            @endif
                            <ul class="flex flex-col gap-8">
                                @foreach ($features as $feature)
                                    <li class="flex gap-12 text-p text-paper/80">
                                        <i class="ph-light ph-check mt-2 text-[18px] text-muted" aria-hidden="true"></i>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </article>
    @endforeach
</div>
