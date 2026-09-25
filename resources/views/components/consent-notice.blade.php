<div class="rounded-lg border border-navy-100 bg-navy-50 p-4 text-xs leading-relaxed text-navy-600">
    <p class="font-semibold text-navy-800">{{ __('Aydınlatma Metni') }}</p>
    <p class="mt-1">
        {{ __('Bu form aracılığıyla paylaştığınız kişisel veriler, 6698 sayılı KVKK kapsamında yalnızca ilgili İK ve Kariyer modülünün işletilmesi amacıyla işlenir. Platform herhangi bir atama veya istihdam garantisi vermez. T.C. kimlik numarası, sağlık bilgisi veya adli sicil kaydı gibi özel nitelikli veriler talep edilmez ve toplanmaz.') }}
        <a href="{{ lroute('legal.kvkk') }}" class="font-medium text-turquoise-700 hover:underline">{{ __('KVKK Aydınlatma Metni') }}</a>
    </p>
</div>

<x-form.checkbox name="consent_accepted" required>
    {{ __('Aydınlatma metnini okudum, kişisel verilerimin belirtilen amaçla işlenmesine açık rızam ile onay veriyorum.') }}
</x-form.checkbox>
