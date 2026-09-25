<x-layout title="Erişilebilirlik">
    <x-container class="max-w-3xl py-14">
        <h1 class="text-3xl font-bold text-navy-900">{{ __('Erişilebilirlik') }}</h1>
        <div class="prose prose-navy mt-6 max-w-none space-y-4 leading-relaxed text-navy-700">
            <p>{{ __('MİARGEM, tüm kullanıcılar için erişilebilir bir dijital deneyim sunmayı hedeflemektedir.') }}</p>
            <ul class="list-disc space-y-2 pl-5">
                <li>{{ __('Tüm etkileşimli öğeler klavye ile ulaşılabilir ve görünür odak (focus) durumuna sahiptir.') }}</li>
                <li>{{ __('Görseller için açıklayıcı alt metinler kullanılır.') }}</li>
                <li>{{ __('Mobil cihazlarda duyarlı (responsive) menü ve düzen sağlanmıştır.') }}</li>
                <li>{{ __('Renk kontrastları WCAG AA standardını gözetecek şekilde tasarlanmıştır.') }}</li>
            </ul>
            <p>{{ __('Erişilebilirlik ile ilgili geri bildirimlerinizi info@miargem.org adresinden bize iletebilirsiniz.') }}</p>
        </div>
    </x-container>
</x-layout>
