<x-layout title="Haberler">
    <x-container class="py-12">
        <x-section-heading eyebrow="Güncel" :title="__('Haberler')" />

        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($newsItems as $item)
                <a href="{{ lroute('news.show', $item) }}" class="group overflow-hidden rounded-xl bg-white shadow-sm hover:shadow-md">
                    @if ($item->featured_image)
                        <img src="{{ asset('storage/'.$item->featured_image) }}" alt="{{ $item->title }}" class="h-40 w-full object-cover" />
                    @endif
                    <div class="flex items-start gap-4 p-5">
                        <span class="shrink-0 text-center leading-none">
                            <span class="block text-3xl font-extrabold text-red-700">{{ $item->published_at?->translatedFormat('d') }}</span>
                            <span class="mt-1 block text-[10px] font-semibold uppercase tracking-wide text-navy-400">{{ mb_strtoupper((string) $item->published_at?->translatedFormat('M')) }}</span>
                        </span>
                        <span class="min-w-0">
                            <span class="block text-[11px] font-semibold uppercase tracking-wide text-turquoise-700">{{ $item->category?->name }}</span>
                            <span class="mt-1 block text-sm font-semibold leading-snug text-navy-900 group-hover:text-turquoise-700">{{ $item->title }}</span>
                        </span>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-sm text-navy-500">{{ __('Henüz haber eklenmedi.') }}</p>
            @endforelse
        </div>

        <div class="mt-10">{{ $newsItems->links() }}</div>
    </x-container>
</x-layout>
