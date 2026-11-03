<x-layout title="İK ve Kariyer">
    <section class="bg-bordo-800 py-16 text-white">
        <x-container>
            <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-bordo-100">{{ __('MİARGEM') }}</p>
            <h1 class="max-w-2xl text-3xl font-bold sm:text-4xl">{{ __('İK ve Kariyer') }}</h1>
            <p class="mt-4 max-w-2xl text-bordo-50/90">
                {{ __('Personel ihtiyaçları, görev yeri tercihleri ve iş / staj başvuruları için ortak başvuru alanı.') }}
            </p>
        </x-container>
    </section>

    <x-container class="py-14">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            @foreach ([
                ['num' => '01', 'title' => 'Personel Talebi', 'desc' => 'Kurumunuzun personel ihtiyacını görev, eğitim, deneyim ve yetkinlik ölçütleriyle tanımlayın.', 'route' => 'career.personnel-request', 'cta' => 'Personel Talebi Oluştur'],
                ['num' => '02', 'title' => 'Nakil Ağı', 'desc' => 'Mevcut görev bilgilerinizi ve görev yeri tercihlerinizi paylaşın; profilinizin güncelliğini yönetin.', 'route' => 'career.transfer-network', 'cta' => 'Nakil Profili Oluştur'],
                ['num' => '03', 'title' => 'İş / Staj Başvurusu', 'desc' => 'İş veya staj tercihinizi belirterek eğitim, deneyim ve ilgi alanı bilgilerinizi paylaşın.', 'route' => 'career.job-internship', 'cta' => 'Başvuru Yap'],
            ] as $module)
                <x-card class="flex h-full flex-col p-6">
                    <span class="text-3xl font-extrabold text-bordo-700">{{ $module['num'] }}</span>
                    <h2 class="mt-3 text-xl font-semibold text-navy-900">{{ __($module['title']) }}</h2>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-navy-600">{{ __($module['desc']) }}</p>
                    <x-button :href="lroute($module['route'])" variant="outline" class="mt-6 self-start">{{ __($module['cta']) }} →</x-button>
                </x-card>
            @endforeach
        </div>

        <div class="mt-12 rounded-xl border border-navy-100 bg-navy-50 p-6">
            <h2 class="font-semibold text-navy-900">{{ __('Hukuki Çerçeve') }}</h2>
            <p class="mt-2 text-sm leading-relaxed text-navy-600">
                {{ __('Bu platform herhangi bir atama veya istihdam garantisi vermez. T.C. kimlik numarası, sağlık bilgisi veya adli sicil kaydı gibi hassas veriler ilk aşamada toplanmaz. Aydınlatma metni ve açık rıza onayları her form için ayrı ayrı alınır.') }}
            </p>
        </div>
    </x-container>
</x-layout>
