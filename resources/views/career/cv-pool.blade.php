<x-layout title="MİARGEM CV Havuzu">
    <x-container class="max-w-2xl py-12">
        <x-section-heading eyebrow="İK ve Kariyer" :title="__('MİARGEM CV Havuzu')" :hint="__('MİARGEM\'in araştırma, analiz, eğitim ve proje çalışmalarında görev alacak uzman havuzu.')" />

        @if (session('status'))
            <x-alert tone="success" class="mt-6">{{ session('status') }}</x-alert>
        @endif

        <form action="{{ lroute('career.cv-pool.store') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-5">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">
                <x-form.input name="full_name" :label="__('Ad Soyad')" :value="auth()->user()?->name" required />
                <x-form.input name="email" type="email" :label="__('E-posta')" :value="auth()->user()?->email" required />
            </div>
            <x-form.input name="expertise_areas" :label="__('Uzmanlık Alanları')" required :hint="__('Örn: Kamu maliyesi, kentsel planlama')" />
            <x-form.select name="visibility" :label="__('Görünürlük Tercihi')" required :options="$visibilityOptions" :hint="__('Profilinizin kimlerle paylaşılacağını belirleyin')" />
            <x-form.textarea name="summary" :label="__('Özgeçmiş Özeti')" required :hint="__('En az 10 karakter')" />
            <x-form.file name="cv" :label="__('CV')" />

            <x-consent-notice />

            <x-button type="submit" variant="primary" class="w-full justify-center">{{ __('Havuza Katıl') }}</x-button>
        </form>
    </x-container>
</x-layout>
