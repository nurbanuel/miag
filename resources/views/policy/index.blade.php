<x-layout title="Politika ve Mevzuat">
    <x-container class="py-12">
        <x-section-heading eyebrow="Politika ve Mevzuat" :title="__('Politika ve Mevzuat')" :hint="__('Mevzuat Etki Notları, Düzenleme Önerileri ve Politika Gündemi')" />

        <div class="mt-6 flex flex-wrap gap-2">
            <a href="{{ lroute('policy.index') }}" class="rounded-full px-4 py-1.5 text-sm font-medium {{ request('type') ? 'bg-navy-50 text-navy-700' : 'bg-navy-900 text-white' }}">{{ __('Tümü') }}</a>
            @foreach (\App\Models\PolicyContent::TYPE_LABELS as $value => $label)
                <a href="{{ lroute('policy.index', ['type' => $value]) }}" class="rounded-full px-4 py-1.5 text-sm font-medium {{ request('type') === $value ? 'bg-navy-900 text-white' : 'bg-navy-50 text-navy-700' }}">{{ $label }}</a>
            @endforeach
        </div>

        <div class="mt-8 grid gap-6 sm:grid-cols-2">
            @forelse ($items as $item)
                <x-card class="flex h-full flex-col overflow-hidden">
                    @if ($item->featured_image)
                        <img src="{{ asset('storage/'.$item->featured_image) }}" alt="" loading="lazy" class="h-48 w-full object-cover" />
                    @endif
                    <div class="flex flex-1 flex-col p-5">
                        <div class="flex flex-wrap items-center gap-2">
                            <x-badge tone="bordo">{{ \App\Models\PolicyContent::TYPE_LABELS[$item->type] ?? $item->type }}</x-badge>
                            @if ($item->published_at)
                                <time datetime="{{ $item->published_at->toDateString() }}" class="text-xs text-navy-500">{{ $item->published_at->translatedFormat('d F Y') }}</time>
                            @endif
                        </div>
                        <h2 class="mt-3 text-lg font-semibold text-navy-900">
                            <a href="{{ lroute('policy.show', $item) }}" class="hover:text-turquoise-700">{{ $item->title }}</a>
                        </h2>
                        <p class="mt-2 text-sm text-navy-600">{{ $item->summary }}</p>
                    </div>
                </x-card>
            @empty
                <p class="col-span-full rounded-lg border border-navy-100 bg-navy-50 p-6 text-navy-600">{{ __('Kayıt bulunamadı.') }}</p>
            @endforelse
        </div>

        <div class="mt-10">{{ $items->links() }}</div>
    </x-container>
</x-layout>
