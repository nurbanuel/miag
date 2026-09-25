<x-layout title="Çerez Politikası">
    <x-container class="max-w-3xl py-14">
        <h1 class="text-3xl font-bold text-navy-900">{{ __('Çerez Politikası') }}</h1>
        <div class="prose prose-navy mt-6 max-w-none space-y-4 leading-relaxed text-navy-700">
            <p>{{ __('Web sitemiz, kullanıcı deneyimini geliştirmek ve site trafiğini analiz etmek amacıyla çerezler (cookies) kullanabilir.') }}</p>
            <h2 class="text-xl font-bold text-navy-900">{{ __('Zorunlu Çerezler') }}</h2>
            <p>{{ __('Oturum yönetimi ve form güvenliği (CSRF koruması) için gerekli olan çerezlerdir; devre dışı bırakılamaz.') }}</p>
            <h2 class="text-xl font-bold text-navy-900">{{ __('Analitik Çerezler') }}</h2>
            <p>{{ __('Site kullanımını anlamamıza yardımcı olan isteğe bağlı çerezlerdir. Tarayıcı ayarlarınızdan bu çerezleri devre dışı bırakabilirsiniz.') }}</p>
        </div>
    </x-container>
</x-layout>
