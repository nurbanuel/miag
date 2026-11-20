<x-layout :title="__('Üye Girişi')">
    <x-container class="py-12 sm:py-16">
        <div class="mx-auto w-full max-w-md">
            <div class="mb-8 text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-turquoise-700">{{ __('MİARGEM Üyelik') }}</p>
                <h1 class="mt-2 text-3xl font-bold text-navy-900">{{ __('Üye Girişi') }}</h1>
                <p class="mt-2 text-sm text-navy-600">{{ __('İK ve Kariyer hizmetlerinden yararlanmak için hesabınıza giriş yapın.') }}</p>
            </div>

            @include('auth.partials.notices')

            <div class="rounded-2xl border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <form method="POST" action="{{ lroute('member.login.store') }}" class="space-y-5" novalidate>
                    @csrf
                    <x-form.input name="email" type="email" :label="__('E-posta')" required autocomplete="email" autofocus />

                    <div>
                        <x-form.input name="password" type="password" :label="__('Şifre')" required autocomplete="current-password" />
                    </div>

                    <label class="flex items-center gap-2 text-sm text-navy-700">
                        <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-navy-300 text-turquoise-600 focus:ring-turquoise-500" @checked(old('remember')) />
                        {{ __('Beni hatırla') }}
                    </label>

                    <button type="submit" class="w-full rounded-lg bg-[#8b1e3f] px-5 py-3 text-sm font-semibold text-white hover:bg-[#721833] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#8b1e3f]">
                        {{ __('Giriş Yap') }}
                    </button>
                </form>
            </div>

            <p class="mt-6 text-center text-sm text-navy-600">
                {{ __('Henüz üye değil misiniz?') }}
                <a href="{{ lroute('member.register') }}" class="font-semibold text-turquoise-700 hover:text-turquoise-800 hover:underline">{{ __('Hemen üye olun') }}</a>
            </p>
        </div>
    </x-container>
</x-layout>
