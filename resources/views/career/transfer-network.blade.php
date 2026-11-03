<x-layout title="Nakil Ağı">
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
                <li><a href="{{ lroute('career.index') }}" class="hover:text-turquoise-700">{{ __('İK ve Kariyer') }}</a></li>
                <li aria-hidden="true">/</li>
                <li aria-current="page" class="font-medium text-navy-800">{{ __('Nakil Ağı') }}</li>
            </ol>
        </nav>

        <h1 class="mt-6 text-3xl font-bold text-navy-900 sm:text-4xl">{{ __('Nakil Ağı') }}</h1>
        <p class="mt-3 max-w-3xl text-navy-600">
            {{ __('Mevcut görev bilgilerinizi ve görev yeri tercihlerinizi yapılandırılmış biçimde paylaşın; profilinizin güncelliğini ve görünürlüğünü yönetin.') }}
        </p>

        <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-12">
            {{-- Sol: dinamik nakil profili formu --}}
            <div class="md:col-span-8">
                @livewire('transfer-network-form')
            </div>

            {{-- Sağ: bilgi kartları --}}
            <aside class="space-y-4 md:col-span-4">
                <div class="rounded-xl border border-navy-100 bg-navy-50 p-5">
                    <h2 class="flex items-center gap-2 font-semibold text-navy-900">
                        <svg class="h-5 w-5 text-turquoise-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        {{ __('Kontrollü Paylaşım') }}
                    </h2>
                    <p class="mt-2 text-sm leading-relaxed text-navy-600">
                        {{ __('Mevcut kurumunuzun ve iletişim bilgilerinizin kimlerle paylaşılacağını ayrı ayrı belirleyin.') }}
                    </p>
                </div>

                <div class="rounded-xl border border-turquoise-100 bg-turquoise-50 p-5">
                    <h2 class="flex items-center gap-2 font-semibold text-navy-900">
                        <svg class="h-5 w-5 text-turquoise-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                        {{ __('Tercih Sırası') }}
                    </h2>
                    <p class="mt-2 text-sm leading-relaxed text-navy-600">
                        {{ __('Birden fazla il, ilçe veya kurumu öncelik sırasıyla ekleyebilirsiniz. Profilinizi güncel tutun.') }}
                    </p>
                </div>
            </aside>
        </div>
    </x-container>
</x-layout>
