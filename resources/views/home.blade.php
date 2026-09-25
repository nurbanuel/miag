{{--
    Ana Sayfa — temiz başlangıç iskeleti.
    Header (x-header) global layout üzerinden geliyor.
    Bu dosyada yalnızca Güncel Duyuru Şeridi bulunur; sonraki bölümler
    kurumsal içerik onaylandıkça buraya eklenecektir.
--}}
<x-layout>
    {{-- Güncel Duyuru Şeridi (renk garantisi için inline style; içerik diğer bölümlerle aynı konteynerde hizalı) --}}
    <div style="background-color: #eaf3f2;" class="w-full">
        <x-container class="flex flex-wrap items-center justify-between gap-4 py-3">
            <span class="inline-flex shrink-0 items-center rounded-full bg-turquoise-600 px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wide text-white">
                {{ __('GÜNCEL') }}
            </span>

            <p class="min-w-[200px] flex-1 text-center text-sm text-navy-800">
                {{ __("Belediye Mevzuat Etki Notları'nın yeni sayısı yayımlandı.") }}
            </p>

            <a href="{{ lroute('policy.index', ['type' => 'mevzuat_etki_notu']) }}" class="shrink-0 text-sm font-semibold text-turquoise-700 hover:text-turquoise-800 hover:underline">
                {{ __('İncele') }} →
            </a>
        </x-container>
    </div>

    {{-- Ana Manşet (Hero Section ve Sağ Sütun) --}}
    <section style="background-color: #f5f7f6;" class="w-full py-10 sm:py-14">
        <x-container>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Sol: Büyük araştırma manşeti kartı (3 kolonun 2'si) — düz lacivert-turkuaz degrade, çizgisiz --}}
                <div
                    style="background: linear-gradient(135deg, #061024 0%, #0c2b42 100%);"
                    class="flex flex-col justify-between rounded-2xl p-8 text-white lg:col-span-2 lg:p-10"
                >
                    {{-- Üst blok: kicker + başlık + açıklama --}}
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="h-px w-6 shrink-0 bg-turquoise-400"></span>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-turquoise-300">
                                {{ __('Rapor ve Analizler') }}
                            </span>
                        </div>

                        <h1 class="mt-5 max-w-xl text-3xl font-bold leading-tight sm:text-4xl">
                            {{ __('Mahallî idarelerin ortak sorunları için ortak akıl') }}
                        </h1>

                        <p class="mt-4 max-w-lg text-sm leading-relaxed text-white/70 sm:text-base">
                            {{ __('Hukukî, malî ve kurumsal sorunları veriye dayalı politika ve uygulanabilir sistem önerilerine dönüştürüyoruz.') }}
                        </p>
                    </div>

                    {{-- Alt blok: buton + tarih (solda), 360° rozeti (sağda) --}}
                    <div class="mt-12 flex flex-wrap items-end justify-between gap-x-6 gap-y-4 pb-1 pr-1">
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                            <a href="{{ lroute('reports.index') }}" class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-100">
                                {{ __('Rapor ve analizleri incele') }} →
                            </a>
                            <span class="shrink-0 text-sm text-white/50">{{ __('22 Ağustos 2026') }}</span>
                        </div>

                        {{-- 360° etki analizi rozeti (koyu kare kutu, sağda — kart içinde güvenli konum) --}}
                        <div style="background-color: #0b1a2e;" class="mb-2 flex h-14 w-14 shrink-0 flex-col items-center justify-center rounded-lg border border-white/10 text-center leading-none">
                            <span class="text-sm font-bold">{{ __('360°') }}</span>
                            <span class="mt-1 text-[8px] font-medium text-white/60">{{ __('etki analizi') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Sağ: 4'lü promosyon sütunu (3 kolonun kalan 1'i) --}}
                <div class="flex flex-col gap-4 lg:col-span-1">

                    {{-- Kart 1: Etkinlikler --}}
                    <a href="{{ lroute('events.index') }}" class="group flex items-center gap-4 rounded-2xl bg-amber-50 p-4">
                        <span class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-full bg-red-600 text-white leading-none">
                            <span class="text-sm font-bold">24</span>
                            <span class="text-[10px] font-semibold uppercase">{{ __('Eyl') }}</span>
                        </span>
                        <span class="min-w-0">
                            <span class="block text-xs font-semibold uppercase tracking-wide text-red-700">{{ __('Etkinlikler') }}</span>
                            <span class="mt-0.5 block truncate font-semibold text-navy-900 group-hover:text-red-700">{{ __('Belediyelerde Kurumsal Kapasite') }}</span>
                            <span class="mt-0.5 block text-xs font-medium text-navy-500 group-hover:text-red-700">{{ __('Etkinliği incele') }} →</span>
                        </span>
                    </a>

                    {{-- Kart 2: İK ve Kariyer --}}
                    <div class="rounded-2xl bg-turquoise-900 p-4 text-white">
                        <span class="inline-flex items-center rounded-full bg-white/10 px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-turquoise-200">
                            {{ __('Yeni Platform') }}
                        </span>
                        <p class="mt-2 font-semibold">{{ __('İnsan Kaynakları ve Kariyer') }}</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <a href="{{ lroute('career.municipal-staff-request') }}" class="rounded-full border border-white/20 px-2.5 py-1 text-xs font-medium hover:bg-white/10">
                                {{ __('Talep aç') }}
                            </a>
                            <a href="{{ lroute('career.transfer-network') }}" class="rounded-full border border-white/20 px-2.5 py-1 text-xs font-medium hover:bg-white/10">
                                {{ __('Nakil profili') }}
                            </a>
                            <a href="{{ lroute('career.cv-pool') }}" class="rounded-full border border-white/20 px-2.5 py-1 text-xs font-medium hover:bg-white/10">
                                {{ __('CV bırak') }}
                            </a>
                        </div>
                    </div>

                    {{-- Kart 3: Etkin Belediye Proje Yarışması --}}
                    <a href="{{ lroute('project-competition') }}" style="background-color: #8b1e3f;" class="group flex items-center justify-between gap-4 rounded-2xl p-4 text-white hover:brightness-110">
                        <span>
                            <span class="block text-xs font-semibold uppercase tracking-wide text-bordo-100">{{ __('MİARGEM Proje Yarışması') }}</span>
                            <span class="mt-0.5 block font-semibold">{{ __('Etkin Belediye') }}</span>
                        </span>
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/15 group-hover:bg-white/25">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 4.5l6 5.5-6 5.5"/></svg>
                        </span>
                    </a>

                    {{-- Kart 4: Mevzuat Takip Sistemi --}}
                    <a href="{{ lroute('legislation-tracking') }}" class="group flex items-center justify-between gap-4 rounded-2xl bg-turquoise-500 p-4 text-white hover:bg-turquoise-600">
                        <span>
                            <span class="block text-xs font-semibold uppercase tracking-wide text-turquoise-50">{{ __('MİARGEM Sistemi') }}</span>
                            <span class="mt-0.5 block font-semibold">{{ __('Mevzuat Takip') }}</span>
                        </span>
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/15 group-hover:bg-white/25">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 4.5l6 5.5-6 5.5"/></svg>
                        </span>
                    </a>
                </div>
            </div>
        </x-container>
    </section>

    {{-- Önceki Haberler + Kurumsal Yaklaşım --}}
    <section style="background-color: #f5f7f6;" class="w-full py-14 sm:py-16">
        <x-container>

            {{-- Önceki Haberler --}}
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="h-px w-6 shrink-0 bg-turquoise-500"></span>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-turquoise-700">{{ __('GÜNCEL') }}</span>
                    </div>
                    <h2 class="mt-3 font-serif text-2xl font-bold text-navy-900 sm:text-3xl">{{ __('Önceki Haberler') }}</h2>
                </div>
                <a href="{{ lroute('news.index') }}" class="text-sm font-semibold text-turquoise-700 hover:text-turquoise-800 hover:underline">
                    {{ __('Tüm haberler') }} →
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($news as $item)
                    <a href="{{ lroute('news.show', $item) }}" class="group overflow-hidden rounded-xl bg-white shadow-sm hover:shadow-md">
                        @if ($item->featured_image)
                            <img src="{{ asset('storage/'.$item->featured_image) }}" alt="{{ $item->title }}" class="h-32 w-full object-cover" />
                        @endif
                        <div class="flex items-start gap-4 p-5">
                            <span class="shrink-0 text-center leading-none">
                                <span class="block text-3xl font-extrabold text-red-700">{{ $item->published_at?->translatedFormat('d') }}</span>
                                <span class="mt-1 block text-[10px] font-semibold uppercase tracking-wide text-navy-400">{{ mb_strtoupper((string) $item->published_at?->translatedFormat('M')) }}</span>
                            </span>
                            <span class="min-w-0">
                                <span class="block text-[11px] font-semibold uppercase tracking-wide text-turquoise-700">{{ $item->category?->name }}</span>
                                <span class="mt-1 block text-sm font-semibold leading-snug text-navy-900 group-hover:text-turquoise-700">{{ $item->title }}</span>
                            </span>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-sm text-navy-500">{{ __('Henüz haber eklenmedi.') }}</p>
                @endforelse
            </div>

            {{-- Kurumsal Yaklaşım --}}
            <div style="background-color: #061024;" class="mt-14 rounded-2xl p-8 text-white lg:p-12">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:items-center">

                    {{-- Sol sütun: metin alanı --}}
                    <div class="lg:col-span-5">
                        <div class="flex items-center gap-2">
                            <span class="h-px w-6 shrink-0 bg-turquoise-400"></span>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-turquoise-300">{{ __('Kurumsal Yaklaşım') }}</span>
                        </div>
                        <h2 class="mt-5 max-w-md text-2xl font-bold leading-snug sm:text-3xl">
                            {{ __('Sorunu görünür kılan, veriye dayalı çözüm üreten merkez') }}
                        </h2>
                        <p class="mt-4 max-w-md text-sm leading-relaxed text-white/70">
                            {{ __('Saha gözlemlerini kanıta dayalı analize, analiz çıktılarını ise uygulanabilir politika ve mevzuat önerilerine dönüştürüyoruz.') }}
                        </p>
                    </div>

                    {{-- Sağ sütun: 5 aşamalı kutucuklar, yan yana --}}
                    <div class="lg:col-span-7">
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-5">
                            @php
                                $approachSteps = [
                                    ['num' => '01', 'label' => 'Sorunu topla'],
                                    ['num' => '02', 'label' => 'Doğrula ve ölç'],
                                    ['num' => '03', 'label' => 'Seçenek geliştir'],
                                    ['num' => '04', 'label' => 'Metinleştir'],
                                    ['num' => '05', 'label' => 'Sonucu izle'],
                                ];
                            @endphp

                            @foreach ($approachSteps as $step)
                                <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                                    <span class="block text-2xl font-bold text-turquoise-300">{{ $step['num'] }}</span>
                                    <span class="mt-1 block text-sm text-white/80">&middot; {{ __($step['label']) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </x-container>
    </section>

    {{-- Rapor ve Analizler --}}
    <section style="background-color: #f5f7f6;" class="w-full py-14 sm:py-16">
        <x-container>

            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="h-px w-6 shrink-0 bg-turquoise-500"></span>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-turquoise-700">{{ __('SEÇKİ') }}</span>
                    </div>
                    <h2 class="mt-3 font-serif text-2xl font-bold text-navy-900 sm:text-3xl">{{ __('Rapor ve Analizler') }}</h2>
                </div>
                <a href="{{ lroute('reports.index') }}" class="text-sm font-semibold text-turquoise-700 hover:text-turquoise-800 hover:underline">
                    {{ __('Tüm rapor ve analizler') }} →
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
                @php
                    $featuredReports = [
                        [
                            'num' => '01',
                            'strip' => '#072e4f',
                            'kicker' => 'Araştırma Raporu',
                            'title' => 'Türkiye Mahalli İdareler Sisteminin Durumu',
                            'desc' => 'Mahalli idarelerin yasal çerçevesi, teşkilat yapısı ve güncel kapasite göstergelerini bütüncül olarak ele alan kapsamlı durum raporu.',
                        ],
                        [
                            'num' => '02',
                            'strip' => '#0c9299',
                            'kicker' => 'Karşılaştırmalı Analiz',
                            'title' => 'Görev-Yetki-Kaynak Dengesi',
                            'desc' => 'Merkezi yönetim ile yerel yönetimler arasındaki görev, yetki ve kaynak paylaşımını karşılaştırmalı olarak inceleyen analiz çalışması.',
                        ],
                        [
                            'num' => '03',
                            'strip' => '#9f1e3b',
                            'kicker' => 'Etki Analizi',
                            'title' => 'Belediye Mevzuatının Kurumsal Etkileri',
                            'desc' => 'Belediyeleri düzenleyen mevzuatın kurumsal kapasite ve hizmet sunumu üzerindeki etkilerini değerlendiren etki analizi raporu.',
                        ],
                    ];
                @endphp

                @foreach ($featuredReports as $report)
                    <a href="{{ lroute('reports.index') }}" class="group flex overflow-hidden rounded-xl bg-white shadow-sm hover:shadow-md">
                        <div style="background-color: {{ $report['strip'] }};" class="flex w-16 shrink-0 items-start justify-center pt-5 sm:w-20">
                            <span class="text-3xl font-extrabold text-white">{{ $report['num'] }}</span>
                        </div>
                        <div class="flex-1 p-5">
                            <span class="block text-[11px] font-semibold uppercase tracking-wide text-turquoise-700">{{ __($report['kicker']) }}</span>
                            <h3 class="mt-2 text-base font-semibold text-navy-900 group-hover:text-turquoise-700">{{ __($report['title']) }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-navy-600">{{ __($report['desc']) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </x-container>
    </section>

    {{-- İstatistik ve Araştırma Altyapısı --}}
    <section style="background-color: #f5f7f6;" class="w-full py-14 sm:py-16">
        <x-container>
            <div style="background-color: #0D858D;" class="rounded-2xl p-8 text-white lg:p-12">
                <div class="grid grid-cols-1 items-center gap-8 lg:grid-cols-12">

                    {{-- Sol sütun: metin alanı --}}
                    <div class="lg:col-span-5">
                        <div class="flex items-center gap-2">
                            <span class="h-px w-6 shrink-0 bg-white/50"></span>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-white/80">
                                {{ __('Türkiye Belediyecilik Dokümantasyonu') }}
                            </span>
                        </div>
                        <h2 class="mt-5 max-w-md text-2xl font-bold leading-snug sm:text-3xl">
                            {{ __('Yerel yönetim sistemini sürekli veriye izleyen araştırma altyapısı') }}
                        </h2>
                        <p class="mt-4 max-w-md text-sm leading-relaxed text-white/80">
                            {{ __('Belediyelerin yerel sermayeli, kurumsal, mali, yapısal ve kurumsal kapasite süreçlerini sürekli olarak izliyoruz.') }}
                        </p>
                    </div>

                    {{-- Sağ sütun: beyaz kart — istatistikler + trend grafiği --}}
                    <div class="lg:col-span-7">
                        <div class="rounded-2xl bg-white p-6 sm:p-8">

                            {{-- 5 istatistik mini kutusu --}}
                            <div class="grid grid-cols-3 gap-4 sm:grid-cols-5 sm:gap-3">
                                @php
                                    $localGovStats = [
                                        ['value' => '1.393', 'label' => 'Toplam Yerel Yönetim / Belde'],
                                        ['value' => '30', 'label' => 'Büyükşehir'],
                                        ['value' => '51', 'label' => 'İl / İlgili Alan'],
                                        ['value' => '922', 'label' => 'İlçe Belediyesi'],
                                        ['value' => '390', 'label' => 'Belde Belediyesi'],
                                    ];
                                @endphp

                                @foreach ($localGovStats as $stat)
                                    <div class="text-center">
                                        <span class="block text-2xl font-extrabold text-navy-900 sm:text-3xl">{{ $stat['value'] }}</span>
                                        <span class="mt-1 block text-[10px] leading-tight text-navy-500 sm:text-[11px]">{{ __($stat['label']) }}</span>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Artış trendini gösteren çizgi grafik (turkuaz + bordo) --}}
                            <div class="mt-6 border-t border-navy-100 pt-6">
                                <svg viewBox="0 0 400 110" class="h-24 w-full sm:h-28" preserveAspectRatio="none" role="img" aria-label="{{ __('Yerel yönetim göstergelerinde yıllar içindeki artış trendini gösteren örnek çizgi grafik') }}">
                                    <polyline points="0,90 60,80 120,70 180,60 240,45 300,32 360,18 400,10" fill="none" stroke="#0c9299" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                    <polyline points="0,100 60,96 120,92 180,80 240,70 300,62 360,50 400,40" fill="none" stroke="#9f1e3b" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="mt-2 text-xs text-navy-500">* {{ __('Gösterilen eğilim yer tutucudur; canlı veri bağlantısı geliştirme aşamasındadır.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-container>
    </section>

    {{-- Politika ve Mevzuat --}}
    <section style="background-color: #f5f7f6;" class="w-full py-14 sm:py-16">
        <x-container>
            <div style="background-color: #f6f1eb;" class="rounded-2xl p-8 lg:p-12">
                <div class="grid grid-cols-1 items-center gap-8 lg:grid-cols-12">

                    {{-- Sol sütun: metin alanı --}}
                    <div class="lg:col-span-5">
                        <div class="flex items-center gap-2">
                            <span class="h-px w-6 shrink-0 bg-bordo-500"></span>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-bordo-700">
                                {{ __('Politika ve Mevzuat') }}
                            </span>
                        </div>
                        <h2 class="mt-5 max-w-md font-serif text-2xl font-bold leading-snug text-navy-900 sm:text-3xl">
                            {{ __('Düzenleme yapılmadan önce etkisini görünür kılmak') }}
                        </h2>
                        <p class="mt-4 max-w-md text-sm leading-relaxed text-navy-600">
                            {{ __('Belediyeleri etkileyen düzenlemeleri görev, maliyet, personel ve uygulama sonuçları bakımından değerlendiriyoruz.') }}
                        </p>
                    </div>

                    {{-- Sağ sütun: bağlantı satırları --}}
                    <div class="lg:col-span-7">
                        @php
                            $policyLinks = [
                                ['label' => 'Mevzuat Etki Notları', 'type' => 'mevzuat_etki_notu'],
                                ['label' => 'Düzenleme Önerileri', 'type' => 'duzenleme_onerisi'],
                                ['label' => 'Politika Gündemi', 'type' => 'politika_gundemi'],
                            ];
                        @endphp

                        <div class="divide-y divide-navy-900/10">
                            @foreach ($policyLinks as $link)
                                <a href="{{ lroute('policy.index', ['type' => $link['type']]) }}" class="group flex items-center justify-between py-5 first:pt-0 last:pb-0">
                                    <span class="text-lg font-semibold text-navy-900 group-hover:text-bordo-700">{{ __($link['label']) }}</span>
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white text-navy-900 group-hover:bg-bordo-600 group-hover:text-white">
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 4.5l6 5.5-6 5.5"/></svg>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </x-container>
    </section>

    {{-- Yazılar --}}
    <section style="background-color: #f5f7f6;" class="w-full py-14 sm:py-16">
        <x-container>

            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="h-px w-6 shrink-0 bg-turquoise-500"></span>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-turquoise-700">{{ __('İmzalı Değerlendirmeler') }}</span>
                    </div>
                    <h2 class="mt-3 font-serif text-2xl font-bold text-navy-900 sm:text-3xl">{{ __('Yazılar') }}</h2>
                </div>
                <a href="{{ lroute('articles.index') }}" class="text-sm font-semibold text-turquoise-700 hover:text-turquoise-800 hover:underline">
                    {{ __('Tüm yazılar') }} →
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
                @php
                    $featuredArticles = [
                        [
                            'initials' => 'HM',
                            'author' => 'Halil Memiş',
                            'title' => 'Belediye İdaresinde Kurumsal Kapasite: Yapıdan İşleyişe Bütüncül Bakış',
                            'readTime' => '7',
                        ],
                        [
                            'initials' => 'HM',
                            'author' => 'Halil Memiş',
                            'title' => 'Belediyecilikte Hukukî Güvenlik ve Kurumsal Ciddiyet',
                            'readTime' => '6',
                        ],
                        [
                            'initials' => 'HM',
                            'author' => 'Halil Memiş',
                            'title' => 'Görev, Yetki ve Sorumluluk Dengesini Yeniden Düşünmek',
                            'readTime' => '9',
                        ],
                    ];
                @endphp

                @foreach ($featuredArticles as $article)
                    <a href="{{ lroute('articles.index') }}" class="group flex flex-col gap-5 rounded-xl bg-white p-6 shadow-sm hover:shadow-md">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-turquoise-600 text-sm font-bold text-white">
                                {{ $article['initials'] }}
                            </span>
                            <span class="text-sm font-semibold text-navy-800">{{ $article['author'] }}</span>
                        </div>

                        <h3 class="text-lg font-bold leading-snug text-navy-900 group-hover:text-turquoise-700">
                            {{ __($article['title']) }}
                        </h3>

                        <span class="mt-auto text-xs font-medium text-navy-500">
                            {{ $article['readTime'] }} {{ __('dk. okuma') }}
                        </span>
                    </a>
                @endforeach
            </div>
        </x-container>
    </section>

    {{-- Proje/Sistem Kartları + Bülten --}}
    <section style="background-color: #f5f7f6;" class="w-full py-14 sm:py-16">
        <x-container>

            {{-- Yan yana 2 büyük kart --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                {{-- Sol kart: Etkin Belediye Proje Yarışması --}}
                <a href="{{ lroute('project-competition') }}" style="background-color: #b72a4c;" class="group flex flex-col justify-between rounded-2xl p-8 text-white hover:brightness-110 lg:p-10">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/15 text-lg font-bold">E</span>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">{{ __('MİARGEM') }}</span>
                        </div>
                        <h3 class="mt-5 text-2xl font-bold leading-snug sm:text-3xl">{{ __('Etkin Belediye Proje Yarışması') }}</h3>
                        <p class="mt-3 max-w-md text-sm leading-relaxed text-white/75">
                            {{ __('Yerel yönetimlerin yenilikçi, sürdürülebilir ve katılımcı projelerini ödüllendiren yıllık yarışma programına katılın.') }}
                        </p>
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 text-sm font-semibold">
                        {{ __('İncele') }}
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/15 group-hover:bg-white/25">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 4.5l6 5.5-6 5.5"/></svg>
                        </span>
                    </span>
                </a>

                {{-- Sağ kart: Mevzuat Takip Sistemi --}}
                <a href="{{ lroute('legislation-tracking') }}" style="background-color: #0f9da1;" class="group flex flex-col justify-between rounded-2xl p-8 text-white hover:brightness-110 lg:p-10">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/15 text-lg font-bold">M</span>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">{{ __('MİARGEM') }}</span>
                        </div>
                        <h3 class="mt-5 text-2xl font-bold leading-snug sm:text-3xl">{{ __('Mevzuat Takip Sistemi') }}</h3>
                        <p class="mt-3 max-w-md text-sm leading-relaxed text-white/75">
                            {{ __('Belediyeleri ilgilendiren mevzuat değişikliklerini erken uyarı ile takip eden sisteme erişin.') }}
                        </p>
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 text-sm font-semibold">
                        {{ __('İncele') }}
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/15 group-hover:bg-white/25">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 4.5l6 5.5-6 5.5"/></svg>
                        </span>
                    </span>
                </a>
            </div>

            {{-- Bülten / e-posta kayıt bandı --}}
            <div style="background-color: #0f9da1;" class="mt-6 rounded-2xl p-8 text-white lg:p-10">
                <div class="grid grid-cols-1 items-center gap-6 lg:grid-cols-2">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">{{ __('MİARGEM Bülteni') }}</span>
                        <h3 class="mt-2 text-2xl font-bold leading-snug sm:text-3xl">{{ __('Çalışmalarımızdan haberdar olun') }}</h3>
                    </div>

                    <div>
                        @if (session('newsletter_status'))
                            <p class="rounded-lg bg-white/15 px-4 py-3 text-sm font-medium">{{ session('newsletter_status') }}</p>
                        @else
                            <form action="{{ lroute('newsletter.store') }}" method="POST" class="flex flex-col gap-3 sm:flex-row">
                                @csrf
                                <label for="home-newsletter-email" class="sr-only">{{ __('E-posta adresiniz') }}</label>
                                <input
                                    id="home-newsletter-email"
                                    type="email"
                                    name="email"
                                    required
                                    placeholder="{{ __('E-posta adresiniz...') }}"
                                    class="w-full rounded-lg border-0 bg-white px-4 py-3 text-sm text-navy-900 placeholder:text-navy-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-navy-900"
                                />
                                <button type="submit" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-turquoise-900 px-5 py-3 text-sm font-semibold text-white hover:bg-turquoise-700">
                                    {{ __('Abone ol') }} →
                                </button>
                            </form>
                            @error('email')
                                <p class="mt-2 text-sm text-white">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                </div>
            </div>
        </x-container>
    </section>
</x-layout>
