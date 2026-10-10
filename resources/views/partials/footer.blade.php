@php
    $contact = config('app.contact');
    $pages = ['home' => 'home', 'about' => 'about', 'services' => 'services', 'expansion' => 'expansion', 'blog.index' => 'blog'];
@endphp

{{-- Rounded panel inset like the header bar; giant wordmark bleeds off the bottom edge (echoes the home hero). --}}
<footer class="px-12 pb-12 md:px-16 md:pb-16">
    <div class="relative isolate overflow-hidden rounded-[28px] border border-line bg-surface">
        <div class="pointer-events-none absolute -top-160 right-0 -z-1 h-[420px] w-[620px] rounded-full bg-primary/10 blur-[120px]" aria-hidden="true"></div>

        <div class="container pt-56 md:pt-80">
            <div class="grid gap-48 lg:grid-cols-12 lg:gap-32">
                {{-- Contact lead --}}
                <div class="lg:col-span-5">
                    <p class="max-w-sm text-p text-muted">{{ __('common.footer_tagline') }}</p>
                    <a href="mailto:{{ $contact['email'] }}" class="group mt-20 inline-flex items-center gap-12 text-[28px] font-bold tracking-tight transition-colors hover:text-primary md:text-[40px]">
                        {{ $contact['email'] }}
                        <i class="ph ph-arrow-up-right text-[24px] transition-transform duration-300 group-hover:-translate-y-4 group-hover:translate-x-4 md:text-[32px]" aria-hidden="true"></i>
                    </a>
                    <div class="mt-28">
                        <a href="{{ route('contact') }}" class="btn btn-primary">{{ __('common.cta_contact') }}</a>
                    </div>
                </div>

                {{-- Pages --}}
                <nav class="lg:col-span-2" aria-label="{{ __('common.footer_pages') }}">
                    <h2 class="text-ps font-semibold text-paper">{{ __('common.footer_pages') }}</h2>
                    <ul class="mt-16 flex flex-col gap-10">
                        @foreach ($pages as $route => $label)
                            <li><a href="{{ route($route) }}" class="text-p text-muted transition-colors hover:text-paper">{{ __("common.nav.{$label}") }}</a></li>
                        @endforeach
                        <li><a href="{{ route('contact') }}" class="text-p text-muted transition-colors hover:text-paper">{{ __('common.cta_contact') }}</a></li>
                    </ul>
                </nav>

                {{-- Office --}}
                <div class="lg:col-span-3">
                    <h2 class="text-ps font-semibold text-paper">{{ __('common.footer_office') }}</h2>
                    <address class="mt-16 flex flex-col gap-10 text-p not-italic text-muted">
                        <span class="text-paper">{{ __('common.address') }}</span>
                        <span>{{ implode(', ', __('contact.office.lines')) }}</span>
                        <a href="tel:{{ preg_replace('/\s+/', '', $contact['phone']) }}" class="w-fit transition-colors hover:text-paper">{{ $contact['phone'] }}</a>
                    </address>
                </div>

                {{-- Social --}}
                <div class="lg:col-span-2">
                    <h2 class="text-ps font-semibold text-paper">{{ __('common.footer_follow') }}</h2>
                    <ul class="mt-16 flex flex-wrap gap-8">
                        @foreach ($contact['socials'] as $network => $url)
                            <li>
                                <a href="{{ $url }}" aria-label="{{ ucfirst($network) }}"
                                   class="grid h-44 w-44 place-items-center rounded-full border border-line text-paper/80 transition-colors hover:border-primary hover:bg-primary hover:text-ink">
                                    <i class="ph ph-{{ $network }}-logo text-[20px]" aria-hidden="true"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="relative z-1 mt-56 flex flex-col gap-16 border-t border-line pt-20 md:mt-80 md:flex-row md:items-center md:justify-between">
                <p class="text-ps text-muted">&copy; {{ date('Y') }} {{ __('common.rights') }}</p>
                <a href="#" class="inline-flex w-fit items-center gap-8 text-ps font-semibold text-muted transition-colors hover:text-paper">
                    {{ __('common.back_to_top') }}
                    <i class="ph ph-arrow-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <p class="footer-wordmark pointer-events-none select-none px-12 md:px-16" aria-hidden="true">
            @foreach (['I', ' ', 'M', 'U', 'S', 'T'] as $letter)
                <span>{!! $letter === ' ' ? '&nbsp;' : e($letter) !!}</span>
            @endforeach
        </p>
    </div>
</footer>
