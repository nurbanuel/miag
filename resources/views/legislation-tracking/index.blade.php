<x-layout title="Mevzuat Takip Sistemi">
    <section class="bg-navy-950 py-16 text-white">
        <x-container>
            <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-turquoise-400">{{ __('MTS') }}</p>
            <h1 class="max-w-2xl text-3xl font-bold sm:text-4xl">{{ __('Mevzuat Takip Sistemi (MTS)') }}</h1>
            <p class="mt-4 max-w-2xl text-white/75">
                {{ __('Belediyeleri ilgilendiren mevzuat değişikliklerini erken uyarı ile takip etmenizi sağlayan sistem geliştirme aşamasındadır.') }}
            </p>
        </x-container>
    </section>

    <x-container class="grid gap-10 py-14 lg:grid-cols-2">
        <div>
            <h2 class="text-xl font-bold text-navy-900">{{ __('Sistem Ne Sunacak?') }}</h2>
            <ul class="mt-4 space-y-3 text-navy-600">
                <li>{{ __('Resmi Gazete\'de yayımlanan belediyeleri ilgilendiren düzenlemelerin takibi') }}</li>
                <li>{{ __('Taslak mevzuata ilişkin etki değerlendirme notları') }}</li>
                <li>{{ __('E-posta ile anlık bildirim aboneliği') }}</li>
            </ul>
        </div>
        <div class="rounded-xl border border-navy-100 p-6">
            <h3 class="font-semibold text-navy-900">{{ __('Erken Erişim İçin Kaydolun') }}</h3>
            <p class="mt-2 text-sm text-navy-600">{{ __('MTS beta sürümüne erken erişim için bültenimize abone olun.') }}</p>
            <form action="{{ lroute('newsletter.store') }}" method="POST" class="mt-4 flex flex-col gap-2 sm:flex-row">
                @csrf
                <input type="email" name="email" required placeholder="{{ __('E-posta adresiniz') }}" class="w-full rounded-md border border-navy-200 px-3.5 py-2.5 text-sm" />
                <x-button type="submit" variant="turquoise">{{ __('Abone Ol') }}</x-button>
            </form>
        </div>
    </x-container>
</x-layout>
