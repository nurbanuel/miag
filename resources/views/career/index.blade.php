<x-layout title="İK ve Kariyer">
    <section class="bg-bordo-800 py-16 text-white">
        <x-container>
            <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-bordo-100">{{ __('İK ve Kariyer') }}</p>
            <h1 class="max-w-2xl text-3xl font-bold sm:text-4xl">{{ __('İK ve Kariyer Platformu') }}</h1>
            <p class="mt-4 max-w-2xl text-bordo-50/90">
                {{ __('Kullanıcı gizliliğine ve kontrollü eşleşmeye dayalı dört modül aracılığıyla belediyeleri, personeli ve uzmanları bir araya getiriyoruz.') }}
            </p>
        </x-container>
    </section>

    <x-container class="py-14">
        <div class="grid gap-6 sm:grid-cols-2">
            @foreach ([
                ['title' => 'Belediye Personel Talebi', 'desc' => 'Doğrulanmış kurumsal e-postaya sahip belediyelerin süreli personel talebi oluşturması.', 'route' => 'career.municipal-staff-request', 'tone' => 'navy'],
                ['title' => 'Nakil Ağı', 'desc' => 'Başka bir belediyeye geçmek isteyen personel için gizlilik esaslı profil ağı.', 'route' => 'career.transfer-network', 'tone' => 'turquoise'],
                ['title' => 'İş / Staj Başvurusu', 'desc' => 'Yeni mezun, deneyimli aday ve stajyerler için ortak kariyer havuzu.', 'route' => 'career.job-internship', 'tone' => 'bordo'],
                ['title' => 'MİARGEM CV Havuzu', 'desc' => 'MİARGEM projelerinde görev alacak uzman havuzu.', 'route' => 'career.cv-pool', 'tone' => 'turquoise'],
            ] as $module)
                <x-card class="p-6">
                    <x-badge :tone="$module['tone']">{{ __('Modül') }}</x-badge>
                    <h2 class="mt-3 text-xl font-semibold text-navy-900">{{ __($module['title']) }}</h2>
                    <p class="mt-2 text-sm text-navy-600">{{ __($module['desc']) }}</p>
                    <x-button :href="lroute($module['route'])" variant="outline" class="mt-4">{{ __('Modüle Git') }}</x-button>
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
