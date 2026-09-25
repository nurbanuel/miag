<x-layout title="Veri ve Gözlemevi">
    <x-slot:head>
        @vite('resources/js/observatory.js')
    </x-slot:head>

    <section class="bg-turquoise-900 py-14 text-white">
        <x-container>
            <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-turquoise-300">{{ __('Veri ve Gözlemevi') }}</p>
            <h1 class="max-w-2xl text-3xl font-bold sm:text-4xl">{{ __('Yerel Yönetim Göstergeleri') }}</h1>
            <p class="mt-4 max-w-2xl text-turquoise-50/90">
                {{ __('Bu modül aşamalı olarak geliştirilmektedir. Aşağıdaki harita ve göstergeler örnek verilerle gösterilmektedir; canlı veri kaynaklarına bağlandıkça güncellenecektir.') }}
            </p>
        </x-container>
    </section>

    <x-container class="py-12">
        <div class="grid gap-8 lg:grid-cols-[2fr_1fr]">
            <div>
                <h2 class="text-lg font-semibold text-navy-900">{{ __('Türkiye Haritası — Öz Gelir Oranı (örnek)') }}</h2>
                <div id="observatory-map" class="mt-4 h-[420px] w-full rounded-xl border border-navy-100" role="img" aria-label="{{ __('Seçili illerin öz gelir oranını gösteren Türkiye haritası') }}"></div>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-navy-900">{{ __('Veri İndirme') }}</h2>
                <p class="mt-2 text-sm text-navy-600">{{ __('Gösterge verilerini kendi analizleriniz için indirin.') }}</p>
                <div class="mt-4 flex flex-col gap-2">
                    <x-button variant="outline" class="justify-start">{{ __('CSV olarak indir') }} (.csv)</x-button>
                    <x-button variant="outline" class="justify-start">{{ __('Excel olarak indir') }} (.xlsx)</x-button>
                </div>
                <p class="mt-3 text-xs text-navy-500">{{ __('İndirme bağlantıları veri kümeleri yayına alındığında etkinleştirilecektir.') }}</p>
            </div>
        </div>

        <div class="mt-12 grid gap-4 sm:grid-cols-3">
            @foreach ($provinces as $province)
                <div class="rounded-lg border border-navy-100 p-4">
                    <p class="font-semibold text-navy-900">{{ $province['name'] }}</p>
                    <p class="text-sm text-navy-600">{{ __('Öz Gelir Oranı') }}: %{{ $province['ozGelirOrani'] }}</p>
                </div>
            @endforeach
        </div>
    </x-container>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.initObservatoryMap) {
                window.initObservatoryMap('observatory-map', @json($provinces));
            }
        });
    </script>
</x-layout>
