<x-layout :title="$article->title">
    <x-container class="max-w-3xl py-12">
        <nav class="mb-6 text-sm text-navy-500">
            <a href="{{ lroute('articles.index') }}" class="hover:text-turquoise-700">{{ __('Yazılar') }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-navy-800">{{ $article->title }}</span>
        </nav>

        <x-alert tone="error" class="mb-6">
            {{ __('Bu yazı, yazarın kişisel değerlendirmesidir ve MİARGEM\'in kurumsal görüşünü temsil etmez.') }}
        </x-alert>

        <h1 class="text-3xl font-bold text-navy-900">{{ $article->title }}</h1>
        <div class="mt-3 flex items-center gap-3 text-sm text-navy-500">
            <a href="{{ lroute('authors.show', $article->author) }}" class="font-medium text-navy-800 hover:text-turquoise-700">{{ $article->author->name }}</a>
            <span>&middot;</span>
            <time datetime="{{ $article->published_at }}">{{ $article->published_at?->translatedFormat('d F Y') }}</time>
        </div>

        <div class="prose prose-navy mt-8 max-w-none leading-relaxed text-navy-700">
            {!! $article->content !!}
        </div>
    </x-container>
</x-layout>
