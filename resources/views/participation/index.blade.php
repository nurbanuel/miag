<x-layout title="Katılım">
    <x-container class="max-w-2xl py-12">
        <x-section-heading eyebrow="Katılım" :title="__('Katılım')" :hint="__('Rapor/Analiz desteği, veri, etkinlik ya da yazı/iletişim için bize ulaşın.')" />

        @if (session('status'))
            <x-alert tone="success" class="mt-6">{{ session('status') }}</x-alert>
        @endif

        <form action="{{ lroute('participation.store') }}" method="POST" class="mt-8 space-y-5">
            @csrf
            <x-form.select name="type" :label="__('Katılım Türü')" required :placeholder="__('Seçiniz')" :options="$types" />
            <x-form.input name="full_name" :label="__('Ad Soyad')" required />
            <x-form.input name="email" type="email" :label="__('E-posta')" required />
            <x-form.input name="institution" :label="__('Kurum (varsa)')" />
            <x-form.textarea name="message" :label="__('Mesajınız')" required :hint="__('En az 10 karakter')" />
            <x-button type="submit" variant="primary" class="w-full justify-center">{{ __('Gönder') }}</x-button>
        </form>
    </x-container>
</x-layout>
