<x-layout :title="$news->title">
    <x-container class="max-w-3xl py-12">
        <nav class="mb-6 text-sm text-navy-500">
            <a href="{{ lroute('news.index') }}" class="hover:text-turquoise-700">{{ __('Haberler') }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-navy-800">{{ $news->title }}</span>
        </nav>

        @if ($news->featured_image)
            <img src="{{ asset('storage/'.$news->featured_image) }}" alt="{{ $news->title }}" class="mb-6 h-64 w-full rounded-xl object-cover sm:h-80" />
        @endif

        <x-badge tone="turquoise">{{ $news->category?->name }}</x-badge>
        <h1 class="mt-3 text-3xl font-bold text-navy-900">{{ $news->title }}</h1>
        <p class="mt-2 text-sm text-navy-500">{{ $news->published_at?->translatedFormat('d F Y') }}</p>

        <div class="prose prose-navy mt-6 max-w-none leading-relaxed text-navy-700">
            {!! $news->content !!}
        </div>
    </x-container>
</x-layout>
