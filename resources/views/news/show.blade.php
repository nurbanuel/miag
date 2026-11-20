<x-layout :title="$news->title">
    <x-container class="max-w-3xl py-12">
        <nav class="mb-6 text-sm text-navy-500">
            <a href="{{ lroute('news.index') }}" class="hover:text-turquoise-700">{{ __('Haberler') }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-navy-800">{{ $news->title }}</span>
        </nav>

        @if ($news->featured_image)
            <img src="{{ asset('storage/'.$news->featured_image) }}" alt="{{ $news->title }}" class="mb-6 h-auto w-full rounded-xl object-contain" />
        @endif

        <x-badge tone="turquoise">{{ $news->category?->name }}</x-badge>
        <h1 class="mt-3 text-3xl font-bold text-navy-900">{{ $news->title }}</h1>
        <p class="mt-2 text-sm text-navy-500">{{ $news->published_at?->translatedFormat('d F Y') }}</p>

        @if ($news->lead)
            <p class="mt-6 text-lg font-medium leading-relaxed text-navy-800">{{ $news->lead }}</p>
        @endif

        <div class="prose max-w-none prose-p:my-4 prose-p:leading-relaxed prose-headings:text-navy-900 prose-a:text-turquoise-700 prose-strong:text-navy-900 leading-relaxed text-navy-700 mt-6">
            {!! $news->content !!}
        </div>
    </x-container>
</x-layout>
