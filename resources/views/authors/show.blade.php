<x-layout :title="$author->name">
    <x-container class="py-12">
        <div class="flex items-center gap-4">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-navy-100 text-xl font-bold text-navy-700">
                {{ mb_substr($author->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-2xl font-bold text-navy-900">{{ $author->name }}</h1>
                @if ($author->title)
                    <p class="text-navy-500">{{ $author->title }}</p>
                @endif
            </div>
        </div>

        @if ($author->bio)
            <p class="mt-6 max-w-2xl leading-relaxed text-navy-700">{{ $author->bio }}</p>
        @endif

        <h2 class="mt-10 text-xl font-bold text-navy-900">{{ __('Yazıları') }}</h2>
        <div class="mt-4 grid gap-6 sm:grid-cols-2">
            @forelse ($author->articles as $article)
                <x-card class="p-5">
                    <h3 class="text-lg font-semibold text-navy-900">
                        <a href="{{ lroute('articles.show', $article) }}" class="hover:text-turquoise-700">{{ $article->title }}</a>
                    </h3>
                    <p class="mt-2 text-sm text-navy-600">{{ $article->excerpt }}</p>
                    <time class="mt-3 block text-xs text-navy-500" datetime="{{ $article->published_at }}">{{ $article->published_at?->translatedFormat('d F Y') }}</time>
                </x-card>
            @empty
                <p class="text-navy-600">{{ __('Bu yazara ait yayımlanmış yazı bulunmuyor.') }}</p>
            @endforelse
        </div>
    </x-container>
</x-layout>
