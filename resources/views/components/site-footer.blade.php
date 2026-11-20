@php
$quickLinks = [
    ['title' => __('Rapor ve Analizler'), 'url' => lroute('reports.index')],
    ['title' => __('İK ve Kariyer'), 'url' => lroute('career.index')],
    ['title' => __('Uzman ve Araştırmacı Havuzu'), 'url' => lroute('participation.index')],
];
$corporateLinks = [
    ['title' => __('Hakkımızda ve İletişim'), 'url' => lroute('corporate')],
];
// Yasal metinler panelden yönetilir (Yasal Metinler): yalnızca yayındakiler, sıra numarasına göre.
foreach (\App\Models\LegalDocument::active()->ordered()->get(['title', 'slug']) as $legalDocument) {
    $corporateLinks[] = ['title' => __($legalDocument->title), 'url' => lroute('legal.show', ['slug' => $legalDocument->slug])];
}
@endphp

<footer class="bg-navy-950 text-white/80">
    <x-container class="grid gap-10 py-14 md:grid-cols-[1.4fr_1fr_1fr]">
        {{-- Sol: logo + motto --}}
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="{{ __('MİARGEM - Mahalli İdareler Araştırma ve Geliştirme Merkezi') }}" class="mb-4 h-12 w-auto" />
            <p class="max-w-sm text-sm leading-relaxed">
                {{ __('Mahallî idareler için bağımsız araştırma ve politika merkezi.') }}
            </p>
        </div>

        {{-- Orta: hızlı bağlantılar --}}
        <div>
            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-white">{{ __('Hızlı Bağlantılar') }}</h3>
            <ul class="space-y-2 text-sm">
                @foreach ($quickLinks as $link)
                    <li><a href="{{ $link['url'] }}" class="hover:text-turquoise-300">{{ $link['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        {{-- Sağ: kurumsal --}}
        <div>
            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-white">{{ __('Kurumsal') }}</h3>
            <ul class="space-y-2 text-sm">
                @foreach ($corporateLinks as $link)
                    <li><a href="{{ $link['url'] }}" class="hover:text-turquoise-300">{{ $link['title'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </x-container>

    <div class="border-t border-white/10 py-5">
        <x-container class="flex flex-col items-center justify-between gap-2 text-xs text-white/60 sm:flex-row">
            <p>&copy; {{ date('Y') }} {{ $siteSettings->footer_copyright_text ?? '' }}</p>
            <p>Mahalli İdarelerin Araştırma, Politika ve Kurumsal Kapasite Merkezi</p>
        </x-container>
    </div>
</footer>
