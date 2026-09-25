<x-layout title="Belediye Personel Talebi">
    <x-container class="max-w-2xl py-12">
        <x-section-heading eyebrow="İK ve Kariyer" :title="__('Belediye Personel Talebi')" :hint="__('Doğrulanmış kurumsal e-postaya sahip belediyeler süreli personel talebi oluşturabilir.')" />

        @if (session('status'))
            <x-alert tone="success" class="mt-6">{{ session('status') }}</x-alert>
        @endif

        <form action="{{ lroute('career.municipal-staff-request.store') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-5">
            @csrf
            <x-form.input name="municipality_name" :label="__('Belediye Adı')" required />
            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input name="contact_name" :label="__('Yetkili Ad Soyad')" required />
                <x-form.input name="contact_email" type="email" :label="__('Kurumsal E-posta')" required :hint="__('Gmail, Hotmail gibi kişisel sağlayıcılar kabul edilmez')" />
            </div>
            <x-form.input name="position_title" :label="__('Ünvan')" required />
            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.select name="employment_status" :label="__('İstihdam Statüsü')" required :options="$employmentStatuses" />
                <x-form.input name="min_experience" type="number" :label="__('Aranan Minimum Deneyim (yıl)')" required min="0" />
            </div>
            <x-form.input name="work_location" :label="__('Çalışma Yeri')" required />
            <x-form.textarea name="description" :label="__('Talep Açıklaması')" required :hint="__('En az 10 karakter')" />
            <x-form.file name="attachment" :label="__('İlan/Şartname Eki')" />

            <x-consent-notice />

            <x-button type="submit" variant="primary" class="w-full justify-center">{{ __('Talebi Gönder') }}</x-button>
        </form>
    </x-container>
</x-layout>
