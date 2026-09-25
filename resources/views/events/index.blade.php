<x-layout title="Etkinlikler">
    <x-container class="py-12">
        <x-section-heading eyebrow="Etkinlikler" :title="__('Etkinlikler')" :hint="__('Paneller, çalıştaylar ve söyleşiler')" />

        <h2 class="mt-10 text-xl font-bold text-navy-900">{{ __('Yaklaşan Etkinlikler') }}</h2>
        <div class="mt-4 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($upcoming as $event)
                <x-card class="flex flex-col overflow-hidden">
                    <div class="flex h-32 items-center justify-center bg-turquoise-600">
                        <svg class="h-10 w-10 text-white/90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="flex flex-1 flex-col gap-2 p-5">
                        <p class="text-sm font-semibold text-turquoise-700">{{ $event->starts_at->translatedFormat('d F Y, H:i') }}</p>
                        <h3 class="text-lg font-semibold text-navy-900">
                            <a href="{{ lroute('events.show', $event) }}" class="hover:text-turquoise-700">{{ $event->title }}</a>
                        </h3>
                        <p class="flex-1 text-sm text-navy-600">{{ \Illuminate\Support\Str::limit(strip_tags($event->description), 140) }}</p>
                        <p class="text-xs text-navy-500">{{ $event->location }}</p>
                        <x-button :href="lroute('events.show', $event)" variant="outline" size="sm" class="mt-2 justify-center">{{ __('Kayıt Ol') }}</x-button>
                    </div>
                </x-card>
            @empty
                <p class="col-span-full rounded-lg border border-navy-100 bg-navy-50 p-6 text-navy-600">{{ __('Planlanan etkinlik bulunmuyor.') }}</p>
            @endforelse
        </div>

        <h2 class="mt-14 text-xl font-bold text-navy-900">{{ __('Geçmiş Etkinlik Arşivi') }}</h2>
        <div class="mt-4 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($past as $event)
                <x-card class="p-5 opacity-90">
                    <p class="text-sm font-semibold text-navy-500">{{ $event->starts_at->translatedFormat('d F Y') }}</p>
                    <h3 class="mt-1 text-lg font-semibold text-navy-900">
                        <a href="{{ lroute('events.show', $event) }}" class="hover:text-turquoise-700">{{ $event->title }}</a>
                    </h3>
                    <p class="mt-2 text-sm text-navy-600">{{ $event->location }}</p>
                </x-card>
            @empty
                <p class="col-span-full text-navy-600">{{ __('Arşivde etkinlik bulunmuyor.') }}</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $past->links() }}</div>
    </x-container>
</x-layout>
