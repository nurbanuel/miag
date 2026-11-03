{{--
    Ana Sayfa — temiz başlangıç iskeleti.
    Header (x-header) global layout üzerinden geliyor.
    Bu dosyada yalnızca Güncel Duyuru Şeridi bulunur; sonraki bölümler
    kurumsal içerik onaylandıkça buraya eklenecektir.
--}}
<x-layout>
    {{-- Güncel Duyuru Şeridi: en son duyuru, detay sayfasına bağlanır (renk garantisi için inline style; içerik diğer bölümlerle aynı konteynerde hizalı) --}}
    <div style="background-color: #eaf3f2;" class="w-full">
        <x-container class="flex flex-wrap items-center justify-between gap-4 py-3">
            <span class="inline-flex shrink-0 items-center rounded-full bg-turquoise-600 px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wide text-white">
                {{ __('GÜNCEL') }}
            </span>

            <p class="min-w-[200px] flex-1 text-center text-sm text-navy-800">
                {{ $latestAnnouncement?->title ?? __("Belediye Mevzuat Etki Notları'nın yeni sayısı yayımlandı.") }}
            </p>

            <a href="{{ $latestAnnouncement ? lroute('announcements.show', $latestAnnouncement) : lroute('policy.index', ['type' => 'mevzuat_etki_notu']) }}" class="shrink-0 text-sm font-semibold text-turquoise-700 hover:text-turquoise-800 hover:underline">
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
                    @if (! empty($featuredContent['image']))
                        style="background-color: #061024; background-image: url('{{ $featuredContent['image'] }}');"
                    @else
                        style="background: linear-gradient(135deg, #061024 0%, #0c2b42 100%);"
                    @endif
                    class="relative flex flex-col justify-between overflow-hidden rounded-2xl bg-cover bg-center p-8 text-white lg:col-span-2 lg:p-10"
                >
                    {{-- Görsel varsa üzerine koyu lacivert karartma katmanı --}}
                    @if (! empty($featuredContent['image']))
                        <div class="absolute inset-0 bg-[#0f172a]/80"></div>
                    @endif

                    {{-- Üst blok: kicker + başlık + açıklama --}}
                    <div class="relative z-10">
                        <div class="flex items-center gap-2">
                            <span class="h-px w-6 shrink-0 bg-turquoise-400"></span>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-turquoise-300">
                                {{ $featuredContent ? __($featuredContent['module']) : __('Rapor ve Analizler') }}
                            </span>
                        </div>

                        <h1 class="mt-5 max-w-xl text-3xl font-bold leading-tight sm:text-4xl">
                            {{ $featuredContent['title'] ?? __('Mahallî idarelerin ortak sorunları için ortak akıl') }}
                        </h1>

                        <p class="mt-4 max-w-lg text-sm leading-relaxed text-white/70 sm:text-base">
                            {{ $featuredContent ? $featuredContent['excerpt'] : __('Hukukî, malî ve kurumsal sorunları veriye dayalı politika ve uygulanabilir sistem önerilerine dönüştürüyoruz.') }}
                        </p>
                    </div>

                    {{-- Alt blok: buton + tarih (solda), 360° rozeti (sağda) --}}
                    <div class="relative z-10 mt-12 flex flex-wrap items-end justify-between gap-x-6 gap-y-4 pb-1 pr-1">
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                            <a href="{{ $featuredContent['url'] ?? lroute('reports.index') }}" class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-100">
                                @if ($featuredContent)
                                    {{ match ($featuredContent['type']) {
                                        'report' => __('Raporu İncele'),
                                        'news' => __('Haberi Oku'),
                                        'article' => __('Yazıyı Oku'),
                                        'event' => __('Etkinliği İncele'),
                                        default => __('İncele'),
                                    } }} →
                                @else
                                    {{ __('Rapor ve analizleri incele') }} →
                                @endif
                            </a>
                            @if (! empty($featuredContent['date']))
                                <span class="shrink-0 text-sm text-white/50">{{ $featuredContent['date']->translatedFormat('j F Y') }}</span>
                            @endif
                        </div>

                        {{-- 360° etki analizi rozeti (yalnızca içerikte işaretliyse; koyu kare kutu, sağda) --}}
                        @if (! empty($featuredContent['has_360_badge']))
                            <div style="background-color: #0b1a2e;" class="mb-2 flex h-14 w-14 shrink-0 flex-col items-center justify-center rounded-lg border border-white/10 text-center leading-none">
                                <span class="text-sm font-bold">{{ __('360°') }}</span>
                                <span class="mt-1 text-[8px] font-medium text-white/60">{{ __('etki analizi') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Sağ: 4'lü promosyon sütunu (3 kolonun kalan 1'i) --}}
                <div class="flex flex-col gap-4 lg:col-span-1">

                    {{-- Kart 1: Etkinlikler (yaklaşan etkinlik varsa onu, yoksa genel takvim erişimini gösterir) --}}
                    @if ($upcomingEvent)
                        <a href="{{ lroute('events.show', $upcomingEvent) }}" class="group flex items-center gap-4 rounded-2xl bg-amber-50 p-4">
                            <span class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-full bg-red-600 text-white leading-none">
                                <span class="text-sm font-bold">{{ $upcomingEvent->starts_at->format('d') }}</span>
                                <span class="text-[10px] font-semibold uppercase">{{ mb_strtoupper((string) $upcomingEvent->starts_at->translatedFormat('M')) }}</span>
                            </span>
                            <span class="min-w-0">
                                <span class="block text-xs font-semibold uppercase tracking-wide text-red-700">{{ __('YAKLAŞAN ETKİNLİK') }}</span>
                                <span class="mt-0.5 block truncate font-semibold text-navy-900 group-hover:text-red-700">{{ $upcomingEvent->title }}</span>
                                <span class="mt-0.5 block text-xs font-medium text-navy-500 group-hover:text-red-700">{{ $upcomingEvent->starts_at->translatedFormat('j F Y, H:i') }} →</span>
                            </span>
                        </a>
                    @else
                        <a href="{{ lroute('events.index') }}" class="group flex items-center gap-4 rounded-2xl bg-amber-50 p-4">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-600 text-white">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="4.5" width="14" height="12" rx="2"/><path stroke-linecap="round" d="M3 8.5h14M7 3v3M13 3v3"/></svg>
                            </span>
                            <span class="min-w-0">
                                <span class="block text-xs font-semibold uppercase tracking-wide text-red-700">{{ __('ETKİNLİK TAKVİMİ') }}</span>
                                <span class="mt-0.5 block truncate font-semibold text-navy-900 group-hover:text-red-700">{{ __('Tüm etkinlikler ve arşiv') }}</span>
                                <span class="mt-0.5 block text-xs font-medium text-navy-500 group-hover:text-red-700">{{ __('Takvimi görüntüle') }} →</span>
                            </span>
                        </a>
                    @endif

                    {{-- Kart 2: İK ve Kariyer --}}
                    <div class="rounded-2xl bg-turquoise-900 p-4 text-white">
                        <span class="inline-flex items-center rounded-full bg-white/10 px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-turquoise-200">
                            {{ __('MAHALLÎ İDARELER İÇİN') }}
                        </span>
                        <p class="mt-2 font-semibold">{{ __('İnsan Kaynakları ve Kariyer') }}</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <a href="{{ lroute('career.personnel-request') }}" class="rounded-full border border-white/20 px-2.5 py-1 text-xs font-medium hover:bg-white/10">
                                {{ __('Personel Talebi') }}
                            </a>
                            <a href="{{ lroute('career.transfer-network') }}" class="rounded-full border border-white/20 px-2.5 py-1 text-xs font-medium hover:bg-white/10">
                                {{ __('Nakil Ağı') }}
                            </a>
                            <a href="{{ lroute('career.job-internship') }}" class="rounded-full border border-white/20 px-2.5 py-1 text-xs font-medium hover:bg-white/10">
                                {{ __('İş / Staj') }}
                            </a>
                        </div>
                    </div>

                    {{-- Kart 3: Etkin Belediye Proje Yarışması --}}
                    <a href="{{ lroute('page.show', ['slug' => 'belediye-proje-gunleri-programi']) }}" style="background-color: #8b1e3f;" class="group flex items-center justify-between gap-4 rounded-2xl p-4 text-white hover:brightness-110">
                        <span>
                            <span class="block text-xs font-semibold uppercase tracking-wide text-bordo-100">{{ __('BELEDİYE PROJE GÜNLERİ') }}</span>
                            <span class="mt-0.5 block font-semibold">{{ __('Etkin Belediye Proje Yarışması') }}</span>
                        </span>
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/15 group-hover:bg-white/25">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 4.5l6 5.5-6 5.5"/></svg>
                        </span>
                    </a>

                    {{-- Kart 4: Mevzuat Takip Sistemi --}}
                    <a href="{{ lroute('legislation-tracking') }}" class="group flex items-center justify-between gap-4 rounded-2xl bg-turquoise-500 p-4 text-white hover:bg-turquoise-600">
                        <span>
                            <span class="block text-xs font-semibold uppercase tracking-wide text-turquoise-50">{{ __('MEVZUAT DESTEĞİ') }}</span>
                            <span class="mt-0.5 block font-semibold">{{ __('Mevzuat Takip Sistemi') }}</span>
                        </span>
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/15 group-hover:bg-white/25">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 4.5l6 5.5-6 5.5"/></svg>
                        </span>
                    </a>
                </div>
            </div>
        </x-container>
    </section>

    {{-- Haberler --}}
    <section style="background-color: #f5f7f6;" class="w-full py-14 sm:py-16">
        <x-container>

            {{-- Haberler --}}
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="h-px w-6 shrink-0 bg-turquoise-500"></span>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-turquoise-700">{{ __('GÜNCEL') }}</span>
                    </div>
                    <h2 class="mt-3 font-serif text-2xl font-bold text-navy-900 sm:text-3xl">{{ __('Haberler') }}</h2>
                </div>
                <a href="{{ lroute('news.index') }}" class="text-sm font-semibold text-turquoise-700 hover:text-turquoise-800 hover:underline">
                    {{ __('Tüm haberler') }} →
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($news as $item)
                    <a href="{{ lroute('news.show', $item) }}" class="group flex h-full flex-col overflow-hidden rounded-xl bg-white shadow-sm hover:shadow-md">
                        {{-- Görsel alanı (görsel yoksa kurumsal lacivert yedek zemin) --}}
                        @if ($item->featured_image)
                            <img src="{{ asset('storage/'.$item->featured_image) }}" alt="{{ $item->title }}" loading="lazy" class="h-40 w-full shrink-0 object-cover" />
                        @else
                            <span style="background: linear-gradient(135deg, #061024 0%, #0c2b42 100%);" class="flex h-40 w-full shrink-0 items-center justify-center" aria-hidden="true">
                                <svg class="h-8 w-8 text-white/25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="16" rx="2"/><path stroke-linecap="round" d="M7 9h10M7 13h10M7 17h6"/></svg>
                            </span>
                        @endif

                        {{-- İçerik: tarih + kategori üstte, başlık altta --}}
                        <span class="flex flex-1 flex-col p-5">
                            <span class="flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wide">
                                @if ($item->published_at)
                                    <span class="shrink-0 text-red-700">{{ mb_strtoupper((string) $item->published_at->translatedFormat('j M')) }}</span>
                                @endif
                                @if ($item->published_at && $item->category)
                                    <span class="h-3 w-px shrink-0 bg-navy-200" aria-hidden="true"></span>
                                @endif
                                @if ($item->category)
                                    <span class="truncate text-turquoise-700">{{ $item->category->name }}</span>
                                @endif
                            </span>
                            <span class="mt-2 block text-base font-semibold leading-snug text-navy-900 group-hover:text-turquoise-700">{{ $item->title }}</span>
                        </span>
                    </a>
                @empty
                    <p class="col-span-full text-sm text-navy-500">{{ __('Henüz haber eklenmedi.') }}</p>
                @endforelse
            </div>
        </x-container>
    </section>

    {{-- Kurumsal Yaklaşım (Haberler ile Rapor ve Analizler arasında) --}}
    <section style="background-color: #f5f7f6;" class="w-full pb-14 sm:pb-16">
        <x-container>
            <div style="background: linear-gradient(135deg, #061024 0%, #0a2238 100%);" class="overflow-hidden rounded-2xl text-white">
                <div class="p-6 sm:p-10 lg:p-12">
                    {{-- Üst metinler --}}
                    <div class="flex items-center gap-2">
                        <span class="h-px w-6 shrink-0 bg-turquoise-400"></span>
                        <span class="text-xs font-medium uppercase tracking-[0.2em] text-turquoise-300">{{ __('KURUMSAL YAKLAŞIM') }}</span>
                    </div>
                    <h2 class="mt-5 max-w-3xl text-2xl font-bold leading-snug text-white sm:text-3xl lg:text-4xl">
                        {{ __('Sorunu görünür kılan, veriye dayalı çözüm üreten merkez') }}
                    </h2>
                    <p class="mt-3 text-base font-semibold text-turquoise-300 sm:text-lg">
                        {{ __('Ortak sorunları araştırıyor, uygulanabilir çözümler geliştiriyoruz.') }}
                    </p>
                    <p class="mt-4 max-w-3xl text-sm leading-relaxed text-white/70 sm:text-base">
                        {{ __('MİARGEM, mahallî idareler için bağımsız bir araştırma ve politika merkezidir. Hukuk, veri ve saha bilgisine dayalı çalışmalarıyla kurumsal kapasitenin ve kamu hizmetlerinin geliştirilmesine katkı sağlar.') }}
                    </p>

                    {{-- 6 aşamalı yöntem kartları: mobil 1, tablet 2, masaüstü 3 sütun --}}
                    @php
                        $approachSteps = [
                            ['title' => 'Sorunun Belirlenmesi', 'desc' => 'Mahallî idarelerin ve görevlilerinin ortak sorunlarını ve gelişim ihtiyaçlarını belirliyoruz.'],
                            ['title' => 'Araştırma ve Analiz', 'desc' => 'Hukuk, veri ve saha bilgisiyle doğruluyor; etkileri ölçüyor, farklı uygulamaları karşılaştırıyoruz.'],
                            ['title' => 'Çözüm Geliştirme', 'desc' => 'Politika, mevzuat ve sistem seçeneklerini uygulanabilirlik, maliyet ve etki bakımından değerlendiriyoruz.'],
                            ['title' => 'Önerinin Hazırlanması', 'desc' => 'Çözümü gerekçeli düzenleme metinlerine, modellere ve standartlara dönüştürüyoruz.'],
                            ['title' => 'Karar Süreçlerine Katkı', 'desc' => 'Paydaşlarla değerlendirdiğimiz önerileri, kurumsal onayın ardından ilgili karar mercilerine sunuyoruz.'],
                            ['title' => 'İzleme ve Öğrenme', 'desc' => 'Önerilerin mevzuata ve uygulamaya yansımalarını izliyor, sonuçları raporlayarak kurumsal hafızaya aktarıyoruz.'],
                        ];
                    @endphp
                    <div class="mt-10 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($approachSteps as $step)
                            <div class="flex h-full flex-col rounded-xl border border-white/10 bg-white/[0.04] p-5">
                                <span class="text-sm font-bold text-turquoise-300">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <h3 class="mt-2 text-base font-semibold text-white">{{ __($step['title']) }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-white/65">{{ __($step['desc']) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Alt şerit: yöntemin ayrıntıları --}}
                <div class="border-t border-white/10 bg-white/[0.03] px-6 py-4 text-xs leading-relaxed text-white/60 sm:px-10 lg:px-12">
                    <span class="font-semibold uppercase tracking-wide text-turquoise-300">{{ __('Yöntemin Ayrıntıları') }}</span>
                    <span class="mx-2 text-white/25" aria-hidden="true">|</span>
                    {{ __('Sorunu toplama, doğrulama ve ölçme; hukukî inceleme ve karşılaştırma; seçenek geliştirme ve düzenleme metni hazırlama; paydaşlarla değerlendirme ve kurumsal onay; karar vericilere sunma ve kamuoyuna açıklama; sonuçları izleme.') }}
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
                    $reportStrips = ['#072e4f', '#0c9299', '#9f1e3b'];
                @endphp

                @forelse ($featuredReports as $report)
                    <a href="{{ lroute('reports.show', $report) }}" class="group flex overflow-hidden rounded-xl bg-white shadow-sm hover:shadow-md">
                        <div style="background-color: {{ $reportStrips[$loop->index % count($reportStrips)] }};" class="flex w-16 shrink-0 items-start justify-center pt-5 sm:w-20">
                            <span class="text-3xl font-extrabold text-white">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            @if ($report->featured_image)
                                <img src="{{ asset('storage/'.$report->featured_image) }}" alt="" loading="lazy" class="h-40 w-full object-cover" />
                            @endif
                            <div class="p-5">
                            <span class="block text-[11px] font-semibold uppercase tracking-wide text-turquoise-700">{{ $report->category?->name ?? $report->category_label ?? __('Rapor') }}</span>
                            <h3 class="mt-2 text-base font-semibold text-navy-900 group-hover:text-turquoise-700">{{ $report->title }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-navy-600">{{ \Illuminate\Support\Str::limit(strip_tags((string) $report->summary), 160) }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-sm text-navy-500">{{ __('Henüz rapor eklenmedi.') }}</p>
                @endforelse
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
                @forelse ($featuredArticles as $article)
                    @php
                        $authorName = $article->author?->name ?? __('MİARGEM');
                        $initials = collect(preg_split('/\s+/u', trim($authorName)))->filter()->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('');
                    @endphp
                    <a href="{{ lroute('articles.show', $article) }}" class="group flex h-full flex-col gap-5 overflow-hidden rounded-xl bg-white p-6 shadow-sm hover:shadow-md">
                        @if ($article->featured_image)
                            <img src="{{ asset('storage/'.$article->featured_image) }}" alt="" loading="lazy" class="-mx-6 -mt-6 h-40 w-[calc(100%+3rem)] max-w-none object-cover" />
                        @endif
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-turquoise-600 text-sm font-bold text-white">
                                {{ $initials }}
                            </span>
                            <span class="text-sm font-semibold text-navy-800">{{ $authorName }}</span>
                        </div>

                        <h3 class="text-lg font-bold leading-snug text-navy-900 group-hover:text-turquoise-700">
                            {{ $article->title }}
                        </h3>

                        <span class="mt-auto text-xs font-medium text-navy-500">
                            {{ $article->reading_time }}
                        </span>
                    </a>
                @empty
                    <p class="col-span-full text-sm text-navy-500">{{ __('Henüz yazı eklenmedi.') }}</p>
                @endforelse
            </div>
        </x-container>
    </section>

    {{-- Proje/Sistem Kartları + Bülten --}}
    <section style="background-color: #f5f7f6;" class="w-full py-14 sm:py-16">
        <x-container>

            {{-- Yan yana 2 büyük kart --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                {{-- Sol kart: Etkin Belediye Proje Yarışması --}}
                <a href="{{ lroute('page.show', ['slug' => 'belediye-proje-gunleri-programi']) }}" style="background-color: #b72a4c;" class="group flex flex-col justify-between rounded-2xl p-8 text-white hover:brightness-110 lg:p-10">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/15 text-lg font-bold">E</span>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">{{ __('BELEDİYE PROJE GÜNLERİ') }}</span>
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
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">{{ __('MEVZUAT DESTEĞİ') }}</span>
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
            <div id="newsletter-signup" style="background-color: #0f9da1;" class="mt-6 scroll-mt-24 rounded-2xl p-8 text-white lg:p-10">
                <div class="grid grid-cols-1 items-center gap-6 lg:grid-cols-2">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">{{ __('MİARGEM Bülteni') }}</span>
                        <h3 class="mt-2 text-2xl font-bold leading-snug sm:text-3xl">{{ __('Çalışmalarımızdan haberdar olun') }}</h3>
                    </div>

                    <div>
                        {{-- Bildirimler: başarı (yeşil) / hata (kırmızı) --}}
                        @if (session('success'))
                            <div role="status" class="mb-3 flex items-start gap-2.5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-sm">
                                <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.7-9.3a1 1 0 00-1.4-1.4L9 10.6 7.7 9.3a1 1 0 00-1.4 1.4l2 2a1 1 0 001.4 0l4-4z" clip-rule="evenodd"/></svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif
                        @if ($errors->newsletter->any())
                            <div role="alert" class="mb-3 flex items-start gap-2.5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800 shadow-sm">
                                <svg class="mt-0.5 h-4 w-4 shrink-0 text-red-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 6a1 1 0 112 0v4a1 1 0 11-2 0V6zm1 8.25a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5z" clip-rule="evenodd"/></svg>
                                <span>{{ $errors->newsletter->first('email') }}</span>
                            </div>
                        @endif

                        <form action="{{ lroute('newsletter.store') }}" method="POST" class="flex flex-col gap-3 sm:flex-row">
                            @csrf
                            <label for="home-newsletter-email" class="sr-only">{{ __('E-posta adresiniz') }}</label>
                            <input
                                id="home-newsletter-email"
                                type="email"
                                name="email"
                                value="{{ $errors->newsletter->any() ? old('email') : '' }}"
                                required
                                placeholder="{{ __('E-posta adresiniz...') }}"
                                @if ($errors->newsletter->any()) aria-invalid="true" @endif
                                class="w-full rounded-lg border-0 bg-white px-4 py-3 text-sm text-navy-900 placeholder:text-navy-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-navy-900"
                            />
                            <button type="submit" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-turquoise-900 px-5 py-3 text-sm font-semibold text-white hover:bg-turquoise-700">
                                {{ __('Abone ol') }} →
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </x-container>
    </section>
</x-layout>
