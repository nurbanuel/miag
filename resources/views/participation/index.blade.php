<x-layout title="Uzman ve Araştırmacı Havuzu">
    <x-slot:head>
        @filamentStyles
        @vite('resources/css/filament-forms.css')
    </x-slot:head>

    <x-slot:scripts>
        @filamentScripts
    </x-slot:scripts>

    <x-container class="py-10 sm:py-12">
        {{-- Breadcrumb --}}
        <nav aria-label="{{ __('Sayfa konumu') }}" class="text-sm text-navy-500">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ lroute('home') }}" class="hover:text-turquoise-700">{{ __('Ana Sayfa') }}</a></li>
                <li aria-hidden="true">/</li>
                <li aria-current="page" class="font-medium text-navy-800">{{ __('Katılım') }}</li>
            </ol>
        </nav>

        <h1 class="mt-6 text-3xl font-bold text-navy-900 sm:text-4xl">{{ __('MİARGEM Uzman ve Araştırmacı Havuzu') }}</h1>
        <p class="mt-3 max-w-3xl text-navy-600">
            {{ __('Araştırma, analiz, eğitim ve proje çalışmalarına katkı sunmak isteyen uzman ve araştırmacılar bilgi ve deneyimlerini bu havuz üzerinden paylaşabilir.') }}
        </p>

        <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-12">
            {{-- Sol: uzman havuzu formu --}}
            <div class="md:col-span-8">
                @livewire('expert-pool-form')
            </div>

            {{-- Sağ: bilgi kartları --}}
            <aside class="space-y-4 md:col-span-4">
                <div class="rounded-xl border border-navy-100 bg-navy-50 p-5">
                    <h2 class="flex items-center gap-2 font-semibold text-navy-900">
                        <svg class="h-5 w-5 text-turquoise-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        {{ __('MİARGEM’e Katkı') }}
                    </h2>
                    <p class="mt-2 text-sm leading-relaxed text-navy-600">
                        {{ __('Araştırma, veri analizi, mevzuat incelemesi, yayın, eğitim, hakemlik ve proje çalışmaları için katkı alanlarınızı seçin.') }}
                    </p>
                </div>

                <div class="rounded-xl border border-navy-100 bg-navy-50 p-5">
                    <h2 class="flex items-center gap-2 font-semibold text-navy-900">
                        <svg class="h-5 w-5 text-turquoise-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7.4 7.4a1 1 0 01-1.4 0L3.3 9.5a1 1 0 111.4-1.4l3.6 3.6 6.7-6.7a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
                        {{ __('Uzmanlık Profiliniz') }}
                    </h2>
                    <p class="mt-2 text-sm leading-relaxed text-navy-600">
                        {{ __('Eğitiminizi, meslek unvanınızı ve varsa akademik unvanınızı ayrı alanlara yazın. Çalışma bağlantıları ekleyin.') }}
                    </p>
                </div>
            </aside>
        </div>
    </x-container>
</x-layout>
