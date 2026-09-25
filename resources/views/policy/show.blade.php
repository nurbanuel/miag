<x-layout :title="$item->title">
    <x-container class="max-w-3xl py-12">
        <nav class="mb-6 text-sm text-navy-500">
            <a href="{{ lroute('policy.index') }}" class="hover:text-turquoise-700">{{ __('Politika ve Mevzuat') }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-navy-800">{{ $item->title }}</span>
        </nav>

        <x-badge tone="bordo">{{ \App\Models\PolicyContent::TYPE_LABELS[$item->type] ?? $item->type }}</x-badge>
        <h1 class="mt-3 text-3xl font-bold text-navy-900">{{ $item->title }}</h1>
        <p class="mt-2 text-sm text-navy-500">{{ $item->published_at?->translatedFormat('d F Y') }}</p>

        <p class="mt-6 text-lg leading-relaxed text-navy-700">{{ $item->summary }}</p>

        @if ($item->content)
            <div class="prose prose-navy mt-6 max-w-none leading-relaxed text-navy-700">
                {!! $item->content !!}
            </div>
        @endif
    </x-container>
</x-layout>
