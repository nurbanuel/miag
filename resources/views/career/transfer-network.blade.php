<x-layout title="Nakil Ağı">
    <x-container class="py-12">
        <x-section-heading eyebrow="İK ve Kariyer" :title="__('Nakil Ağı')" :hint="__('Başka bir belediyeye geçmek isteyen personel için gizlilik esaslı profil ağı. Ad ve kurum bilgileri, aday onayı olmadan görüntülenmez.')" />

        <div class="mt-10 grid gap-10 lg:grid-cols-[1fr_1.2fr]">
            <div>
                @if (session('status'))
                    <x-alert tone="success" class="mb-6">{{ session('status') }}</x-alert>
                @endif

                <form action="{{ lroute('career.transfer-network.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <x-form.input name="current_title" :label="__('Mevcut Ünvanınız')" required />
                    <x-form.input name="current_institution" :label="__('Mevcut Kurumunuz')" required :hint="__('Onay vermeden diğer kullanıcılara gösterilmez')" />
                    <x-form.input name="target_locations" :label="__('Hedef Çalışma Yerleri')" required :hint="__('Örn: İstanbul, Bursa')" />
                    <x-form.input name="experience_years" type="number" :label="__('Deneyim (yıl)')" required min="0" />
                    <x-form.textarea name="summary" :label="__('Kısa Özet')" required :hint="__('Uzmanlık alanınızı ve nakil gerekçenizi kısaca belirtin')" />
                    <x-form.input name="contact_email" type="email" :label="__('İletişim E-postası')" required :hint="__('Yalnızca MİARGEM ile paylaşılır')" />

                    <x-consent-notice />

                    <x-button type="submit" variant="primary" class="w-full justify-center">{{ __('Gizli Profil Oluştur') }}</x-button>
                </form>
            </div>

            <div>
                <h2 class="text-lg font-bold text-navy-900">{{ __('Ağdaki Anonim Profiller') }}</h2>
                <div class="mt-4 space-y-3">
                    @forelse ($profiles as $profile)
                        <x-card class="p-4">
                            <p class="font-semibold text-navy-900">{{ $profile->current_title }}</p>
                            <p class="text-sm text-navy-600">{{ __('Hedef') }}: {{ $profile->target_locations }} · {{ $profile->experience_years }} {{ __('yıl deneyim') }}</p>
                            <p class="mt-2 text-sm text-navy-600">{{ \Illuminate\Support\Str::limit($profile->summary, 140) }}</p>
                            @if (!$profile->is_identity_revealed)
                                <p class="mt-2 text-xs font-medium text-bordo-600">{{ __('Kimlik bilgileri gizli — yalnızca aday onayıyla açılır') }}</p>
                            @endif
                        </x-card>
                    @empty
                        <p class="text-navy-600">{{ __('Ağda henüz profil bulunmuyor.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </x-container>
</x-layout>
