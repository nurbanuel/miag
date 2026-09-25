<x-layout title="Kurumsal">
    <section class="bg-navy-950 py-16 text-white">
        <x-container>
            <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-turquoise-400">{{ $page->banner_title ?? __('Kurumsal') }}</p>
            <h1 class="max-w-2xl text-3xl font-bold sm:text-4xl">{{ $page->banner_subtitle ?? __('Hakkımızda') }}</h1>
            <p class="mt-4 max-w-2xl text-white/75">
                {{ $page->banner_description ?? __('MİARGEM, belediye yöneticileri, çalışanları, akademisyenler, araştırmacılar ve yerel yönetim uzmanları için bağımsız bir araştırma, yayın, veri ve katılım merkezidir.') }}
            </p>
        </x-container>
    </section>

    <x-container class="grid gap-12 py-16 lg:grid-cols-3">
        <div class="prose prose-navy max-w-none lg:col-span-2">
            {!! $page->content !!}
        </div>

        <div>
            {!! $page->sidebar_content !!}

            <div id="iletisim" class="mt-8 rounded-lg border border-navy-100 bg-navy-50 p-5">
                <h3 class="font-semibold text-navy-900">{{ __('İletişim') }}</h3>
                <p class="mt-2 text-sm text-navy-600">info@miargem.org</p>
                <p class="mt-1 text-sm text-navy-600">+90 (312) 000 00 00</p>
            </div>
        </div>
    </x-container>
</x-layout>
