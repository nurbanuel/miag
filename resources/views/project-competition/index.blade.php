<x-layout title="Etkin Belediye Proje Yarışması">
    <section class="bg-bordo-800 py-16 text-white">
        <x-container>
            <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-bordo-100">{{ __('Etkin Belediye') }}</p>
            <h1 class="max-w-2xl text-3xl font-bold sm:text-4xl">{{ __('Etkin Belediye Proje Yarışması') }}</h1>
            <p class="mt-4 max-w-2xl text-bordo-50/90">
                {{ __('Yerel yönetimlerin yenilikçi, sürdürülebilir ve katılımcı projelerini ödüllendiren yıllık yarışma programı.') }}
            </p>
            <x-button href="#basvuru" variant="turquoise" class="mt-6">{{ __('Başvuru Koşullarını Gör') }}</x-button>
        </x-container>
    </section>

    <x-container id="basvuru" class="grid gap-10 py-14 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <h2 class="text-xl font-bold text-navy-900">{{ __('Yarışma Hakkında') }}</h2>
            <p class="mt-4 leading-relaxed text-navy-600">
                {{ __('Etkin Belediye Proje Yarışması, belediyelerin dijital dönüşüm, katılımcı yönetişim, mali sürdürülebilirlik ve kentsel hizmet alanlarında hayata geçirdiği örnek uygulamaları görünür kılmayı amaçlar. Seçilen projeler MİARGEM yayınlarında ve etkinliklerinde tanıtılır.') }}
            </p>
            <h2 class="mt-8 text-xl font-bold text-navy-900">{{ __('Başvuru Takvimi') }}</h2>
            <p class="mt-4 text-navy-600">{{ __('2026 yılı başvuru takvimi yakında bu sayfada yayımlanacaktır.') }}</p>
        </div>
        <aside class="rounded-xl border border-navy-100 p-6">
            <h3 class="font-semibold text-navy-900">{{ __('Başvuru için') }}</h3>
            <p class="mt-2 text-sm text-navy-600">{{ __('Katılım sayfamız üzerinden bize ulaşabilirsiniz.') }}</p>
            <x-button :href="lroute('participation.index')" variant="primary" class="mt-4 w-full justify-center">{{ __('Katılım Sayfasına Git') }}</x-button>
        </aside>
    </x-container>
</x-layout>
