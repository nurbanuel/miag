@php
$locale = app()->getLocale();
$localeHref = fn (string $url) => ($locale === 'en' ? '/en' : '').$url;
$quickLinks = $siteSettings->footer_quick_links ?? [];
$legalLinks = $siteSettings->footer_legal_links ?? [];
@endphp

<footer class="bg-navy-950 text-white/80">
    <x-container class="grid gap-10 py-14 lg:grid-cols-[1.3fr_1fr_1fr_1.2fr]">
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="{{ __('MİARGEM - Mahalli İdareler Araştırma ve Geliştirme Merkezi') }}" class="mb-4 h-12 w-auto" />
            <p class="max-w-sm text-sm leading-relaxed">
                {{ $siteSettings->footer_about_text ?? '' }}
            </p>
        </div>

        <div>
            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-white">{{ __('Hızlı Bağlantılar') }}</h3>
            <ul class="space-y-2 text-sm">
                @foreach ($quickLinks as $link)
                    <li><a href="{{ $localeHref($link['url']) }}" class="hover:text-turquoise-300">{{ $link['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-white">{{ __('Yasal') }}</h3>
            <ul class="space-y-2 text-sm">
                @foreach ($legalLinks as $link)
                    <li><a href="{{ $localeHref($link['url']) }}" class="hover:text-turquoise-300">{{ $link['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        <div id="newsletter-signup">
            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-white">{{ __('Bültenimize Abone Olun') }}</h3>
            <p class="mb-3 text-sm">{{ __('Yeni rapor, etkinlik ve politika notlarından haberdar olun.') }}</p>

            @if (session('newsletter_status'))
                <p class="mb-3 rounded-md bg-turquoise-900/40 px-4 py-2.5 text-sm text-turquoise-100">{{ session('newsletter_status') }}</p>
            @else
                <form action="{{ lroute('newsletter.store') }}" method="POST" class="flex flex-col gap-2 sm:flex-row">
                    @csrf
                    <label for="newsletter-email" class="sr-only">{{ __('E-posta adresiniz') }}</label>
                    <input id="newsletter-email" type="email" name="email" required placeholder="{{ __('E-posta adresiniz') }}" class="w-full rounded-md border border-white/20 bg-white/5 px-4 py-2.5 text-sm text-white placeholder:text-white/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-turquoise-400" />
                    <x-button type="submit" variant="turquoise">{{ __('Abone Ol') }}</x-button>
                </form>
                @error('email')
                    <p class="mt-2 text-sm text-bordo-400">{{ $message }}</p>
                @enderror
            @endif
        </div>
    </x-container>

    <div class="border-t border-white/10 py-5">
        <x-container class="flex flex-col items-center justify-between gap-2 text-xs text-white/60 sm:flex-row">
            <p>&copy; {{ date('Y') }} {{ $siteSettings->footer_copyright_text ?? '' }}</p>
            <p>Mahalli İdarelerin Araştırma, Politika ve Kurumsal Kapasite Merkezi</p>
        </x-container>
    </div>
</footer>
