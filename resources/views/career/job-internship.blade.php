<x-layout title="İş / Staj Başvurusu">
    <x-container class="max-w-2xl py-12">
        <x-section-heading eyebrow="İK ve Kariyer" :title="__('İş / Staj Başvurusu')" :hint="__('Yeni mezun, deneyimli aday ve stajyerler için ortak kariyer havuzu.')" />

        @if (session('status'))
            <x-alert tone="success" class="mt-6">{{ session('status') }}</x-alert>
        @endif

        <form action="{{ lroute('career.job-internship.store') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-5">
            @csrf
            <x-form.select name="applicant_type" :label="__('Aday Türü')" required :placeholder="__('Seçiniz')" :options="$applicantTypes" />
            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input name="full_name" :label="__('Ad Soyad')" required />
                <x-form.input name="email" type="email" :label="__('E-posta')" required />
            </div>
            <x-form.input name="field_of_interest" :label="__('İlgi Alanı / Pozisyon')" required />
            <x-form.file name="cv" :label="__('CV')" />
            <x-form.textarea name="message" :label="__('Eklemek istedikleriniz')" :rows="4" />

            <x-consent-notice />

            <x-button type="submit" variant="primary" class="w-full justify-center">{{ __('Başvuruyu Gönder') }}</x-button>
        </form>
    </x-container>
</x-layout>
