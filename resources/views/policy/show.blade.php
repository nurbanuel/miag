<x-layout :title="$item->title">
    <x-container class="max-w-3xl py-12">
        <nav class="mb-6 text-sm text-navy-500">
            <a href="{{ lroute('policy.index') }}" class="hover:text-turquoise-700">{{ __('Politika ve Mevzuat') }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-navy-800">{{ $item->title }}</span>
        </nav>

@if ($item->featured_image)
            <img src="{{ asset('storage/'.$item->featured_image) }}" alt="{{ $item->title }}" class="mb-6 h-auto w-full rounded-xl object-contain" />
        @endif

        <x-badge tone="bordo">{{ \App\Models\PolicyContent::TYPE_LABELS[$item->type] ?? $item->type }}</x-badge>
        <h1 class="mt-3 text-3xl font-bold text-navy-900">{{ $item->title }}</h1>
        <p class="mt-2 text-sm text-navy-500">{{ $item->published_at?->translatedFormat('d F Y') }}</p>

        @if ($item->lead)
            <p class="mt-6 text-lg font-medium leading-relaxed text-navy-800">{{ $item->lead }}</p>
        @endif

        @if ($item->content)
            <div class="prose max-w-none prose-p:my-4 prose-p:leading-relaxed prose-headings:text-navy-900 prose-a:text-turquoise-700 prose-strong:text-navy-900 leading-relaxed text-navy-700 mt-6">
                {!! $item->content !!}
            </div>
        @endif
    </x-container>
</x-layout>
