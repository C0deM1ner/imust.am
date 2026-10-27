{{-- $contact comes from App\View\Composers\FooterComposer. --}}
@php($pages = ['home' => 'home', 'about' => 'about', 'services' => 'services', 'portfolio.index' => 'portfolio', 'expansion' => 'expansion', 'blog.index' => 'blog'])

{{-- ─── Footer: rounded panel, giant wordmark bleeding off the bottom edge ─── --}}
<footer class="site-footer">
    <div class="site-footer-panel">
        <div class="site-footer-glow" aria-hidden="true"></div>

        <div class="container site-footer-inner">
            <div class="site-footer-grid">
                {{-- Contact lead --}}
                <div class="site-footer-contact">
                    <p class="site-footer-tagline">{{ __('common.footer_tagline') }}</p>
                    <a href="mailto:{{ $contact['email'] }}" class="site-footer-email">
                        {{ $contact['email'] }}
                        <i class="ph ph-arrow-up-right" aria-hidden="true"></i>
                    </a>
                    <div class="mt-28">
                        <a href="{{ route('contact') }}" class="btn btn-primary">{{ __('common.cta_contact') }}</a>
                    </div>
                </div>

                {{-- Pages --}}
                <nav class="site-footer-pages" aria-label="{{ __('common.footer_pages') }}">
                    <h2 class="site-footer-title">{{ __('common.footer_pages') }}</h2>
                    <ul class="site-footer-links">
                        @foreach ($pages as $route => $label)
                            <li><a href="{{ route($route) }}">{{ __("common.nav.{$label}") }}</a></li>
                        @endforeach
                        <li><a href="{{ route('contact') }}">{{ __('common.cta_contact') }}</a></li>
                    </ul>
                </nav>

                {{-- Office --}}
                <div class="site-footer-office">
                    <h2 class="site-footer-title">{{ __('common.footer_office') }}</h2>
                    <address class="site-footer-address">
                        <span class="text-paper">{{ $contact['address'] }}</span>
                        <span>{{ implode(', ', $contact['officeLines']) }}</span>
                        <a href="tel:{{ preg_replace('/\s+/', '', $contact['phone']) }}">{{ $contact['phone'] }}</a>
                    </address>
                </div>

                {{-- Social --}}
                <div class="site-footer-social">
                    <h2 class="site-footer-title">{{ __('common.footer_follow') }}</h2>
                    <ul class="site-footer-socials">
                        @foreach ($contact['socials'] as $network => $url)
                            <li>
                                <a href="{{ $url }}" class="icon-link" aria-label="{{ ucfirst($network) }}">
                                    <i class="ph ph-{{ $network }}-logo" aria-hidden="true"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="site-footer-bottom">
                <p>&copy; {{ date('Y') }} {{ __('common.rights') }}</p>
                <a href="#" class="site-footer-top">
                    {{ __('common.back_to_top') }}
                    <i class="ph ph-arrow-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <p class="site-footer-wordmark" aria-hidden="true">
            @foreach (['I', ' ', 'M', 'U', 'S', 'T'] as $letter)
                <span>{!! $letter === ' ' ? '&nbsp;' : e($letter) !!}</span>
            @endforeach
        </p>
    </div>
</footer>
