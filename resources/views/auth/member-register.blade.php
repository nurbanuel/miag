<x-layout :title="__('Üye Ol')">
    <x-container class="py-12 sm:py-16">
        <div class="mx-auto w-full max-w-lg">
            <div class="mb-8 text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-turquoise-700">{{ __('MİARGEM Üyelik') }}</p>
                <h1 class="mt-2 text-3xl font-bold text-navy-900">{{ __('Üye Ol') }}</h1>
                <p class="mt-2 text-sm text-navy-600">{{ __('Personel talebi, nakil ağı, iş/staj başvurusu ve CV havuzu işlemleri için ücretsiz üyelik oluşturun.') }}</p>
            </div>

            @include('auth.partials.notices')

            <div class="rounded-2xl border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <form method="POST" action="{{ lroute('member.register.store') }}" class="space-y-5" novalidate>
                    @csrf
                    <x-form.input name="name" :label="__('Ad Soyad')" required autocomplete="name" autofocus />

                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-form.input name="email" type="email" :label="__('E-posta')" required autocomplete="email" />
                        <x-form.input name="phone" type="tel" :label="__('Telefon')" :hint="__('İsteğe bağlı')" autocomplete="tel" placeholder="05xx xxx xx xx" />
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-form.input name="password" type="password" :label="__('Şifre')" required autocomplete="new-password" :hint="__('En az 8 karakter, harf ve rakam')" />
                        <x-form.input name="password_confirmation" type="password" :label="__('Şifre Tekrarı')" required autocomplete="new-password" :hint="__('Şifrenizi tekrar girin')" />
                    </div>

                    <div>
                        <label class="flex items-start gap-2 text-sm text-navy-700">
                            <input type="checkbox" name="kvkk" value="1" class="mt-0.5 h-4 w-4 rounded border-navy-300 text-turquoise-600 focus:ring-turquoise-500" @checked(old('kvkk')) required />
                            <span>
                                <a href="{{ lroute('legal.kvkk') }}" target="_blank" rel="noopener" class="font-medium text-turquoise-700 underline">{{ __('KVKK Aydınlatma Metni') }}</a>{{ __('\'ni okudum; üyelik bilgilerimin bu kapsamda işlenmesini kabul ediyorum.') }}
                            </span>
                        </label>
                        @error('kvkk')
                            <p class="mt-1.5 text-sm text-bordo-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-[#8b1e3f] px-5 py-3 text-sm font-semibold text-white hover:bg-[#721833] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#8b1e3f]">
                        {{ __('Üyeliğimi Oluştur') }}
                    </button>
                </form>
            </div>

            <p class="mt-6 text-center text-sm text-navy-600">
                {{ __('Zaten üye misiniz?') }}
                <a href="{{ lroute('member.login') }}" class="font-semibold text-turquoise-700 hover:text-turquoise-800 hover:underline">{{ __('Giriş yapın') }}</a>
            </p>
        </div>
    </x-container>
</x-layout>
