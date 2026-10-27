@php
    // Shared pricing cards (home + services). Text comes from lang/{locale}/services.php.
    // $showDetails: link each card to its section on the services page (off on the services page itself).
    $showDetails = $showDetails ?? true;
    $packageTiers = ['start' => 'Start', 'grow' => 'Grow', 'maintain' => 'Maintain'];
    $packageIcons = ['start' => 'ph-rocket-launch', 'grow' => 'ph-trend-up', 'maintain' => 'ph-shield-check'];
@endphp

<div class="package-cards">
    @foreach ($packageTiers as $key => $tier)
        @php($copy = __("services.items.{$key}"))
        <article id="{{ $key }}" class="package-card" data-fade style="--d:{{ $loop->index }}">
            <div class="package-card-body">
                <i class="ph-light {{ $packageIcons[$key] }} package-card-icon" aria-hidden="true"></i>

                <h3 class="package-card-name">
                    <span class="sr-only">I MUST </span>{{ $tier }}
                </h3>
                <p class="package-card-summary">{{ $copy['summary'] }}</p>

                <div class="package-card-price">
                    <span class="package-card-amount">{{ $copy['price'] }}</span>
                    <span class="package-card-cadence">
                        {{ $copy['cadence'] }}@if ($copy['price_note'])<br>{{ $copy['price_note'] }}@endif
                    </span>
                </div>

                <div class="package-card-note">
                    <i class="ph-light ph-info" aria-hidden="true"></i>
                    <p>{{ $copy['description'] }}</p>
                </div>

                <div class="package-card-actions">
                    <a href="{{ route('contact') }}" class="package-card-button">{{ __('common.cta_contact') }}</a>
                    @if ($showDetails)
                        <a href="{{ route('services') }}#{{ $key }}" class="package-card-details">{{ __('home.packages.details') }}</a>
                    @endif
                </div>
            </div>

            <div class="package-card-features">
                <p class="package-card-included">{{ __('home.packages.included') }}</p>
                <div class="package-card-groups">
                    @foreach ($copy['groups'] as $group => $features)
                        <div>
                            @if (count($copy['groups']) > 1)
                                <p class="package-card-group">{{ $group }}</p>
                            @endif
                            <ul class="package-card-list">
                                @foreach ($features as $feature)
                                    <li>
                                        <i class="ph-light ph-check" aria-hidden="true"></i>
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
