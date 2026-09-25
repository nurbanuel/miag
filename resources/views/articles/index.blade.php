<x-layout title="Yazılar">
    <x-container class="py-12">
        <x-section-heading eyebrow="Yazılar" :title="__('Yazılar')" :hint="__('Uzmanların imzalı kişisel değerlendirmeleri')" />
        <p class="mt-3 text-xs text-navy-500">{{ __('Bu bölümdeki yazılar yazarların kişisel değerlendirmelerini içerir ve MİARGEM\'in kurumsal görüşünü temsil etmez.') }}</p>

        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($articles as $article)
                <x-card class="flex flex-col gap-3 p-5">
                    <h2 class="text-lg font-semibold text-navy-900">
                        <a href="{{ lroute('articles.show', $article) }}" class="hover:text-turquoise-700">{{ $article->title }}</a>
                    </h2>
                    <p class="flex-1 text-sm text-navy-600">{{ $article->excerpt }}</p>
                    <div class="flex items-center justify-between border-t border-navy-100 pt-3 text-xs text-navy-500">
                        <a href="{{ lroute('authors.show', $article->author) }}" class="font-medium text-navy-700 hover:text-turquoise-700">{{ $article->author->name }}</a>
                        <time datetime="{{ $article->published_at }}">{{ $article->published_at?->translatedFormat('d F Y') }}</time>
                    </div>
                </x-card>
            @empty
                <p class="col-span-full rounded-lg border border-navy-100 bg-navy-50 p-6 text-navy-600">{{ __('Henüz yazı yayımlanmadı.') }}</p>
            @endforelse
        </div>

        <div class="mt-10">{{ $articles->links() }}</div>
    </x-container>
</x-layout>
