<x-layout :title="$article->title">
    <x-container class="max-w-3xl py-12">
        <nav class="mb-6 text-sm text-navy-500" aria-label="{{ __('Sayfa konumu') }}">
            @if ($article->isCitizenGuide())
                <a href="{{ lroute('home') }}" class="hover:text-turquoise-700">{{ __('Ana Sayfa') }}</a>
                <span class="mx-1.5">/</span>
                <a href="{{ lroute('citizen-guide.index') }}" class="hover:text-turquoise-700">{{ __('Vatandaş Rehberi') }}</a>
            @else
                <a href="{{ lroute('articles.index') }}" class="hover:text-turquoise-700">{{ __('Yazılar') }}</a>
            @endif
            <span class="mx-1.5">/</span>
            <span class="text-navy-800">{{ $article->title }}</span>
        </nav>

        <x-alert tone="error" class="mb-6">
            {{ __('Bu yazı, yazarın kişisel değerlendirmesidir ve MİARGEM\'in kurumsal görüşünü temsil etmez.') }}
        </x-alert>

@if ($article->featured_image)
            <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}" class="mb-6 h-auto w-full rounded-xl object-contain" />
        @endif

        <h1 class="text-3xl font-bold text-navy-900">{{ $article->title }}</h1>
        <div class="mt-4 flex flex-wrap items-center gap-x-3 gap-y-2 text-sm text-navy-500">
            @if ($article->author)
                <a href="{{ lroute('authors.show', $article->author) }}" class="flex items-center gap-3 font-medium text-navy-800 hover:text-turquoise-700">
                    <x-author-avatar :author="$article->author" size="lg" />
                    <span class="flex flex-col">
                        <span>{{ $article->author->name }}</span>
                        @if ($article->author->title)
                            <span class="text-xs font-normal text-navy-500">{{ $article->author->title }}</span>
                        @endif
                    </span>
                </a>
                <span>&middot;</span>
            @endif
            <time datetime="{{ $article->published_at }}">{{ $article->published_at?->translatedFormat('d F Y') }}</time>
            <span>&middot;</span>
            <span class="font-medium">{{ $article->reading_time }}</span>
        </div>

        @if ($article->lead)
            <p class="mt-6 text-lg font-medium leading-relaxed text-navy-800">{{ $article->lead }}</p>
        @endif

        <div class="prose max-w-none prose-p:my-4 prose-p:leading-relaxed prose-headings:text-navy-900 prose-a:text-turquoise-700 prose-strong:text-navy-900 leading-relaxed text-navy-700 mt-8">
            {!! $article->content !!}
        </div>

        @if ($article->author)
            <aside class="mt-12 rounded-xl border border-navy-100 bg-navy-50/60 p-6" aria-label="{{ __('Yazar Hakkında') }}">
                <div class="flex items-start gap-4">
                    <x-author-avatar :author="$article->author" size="xl" />
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold uppercase tracking-wide text-turquoise-700">{{ __('Yazar Hakkında') }}</p>
                        <a href="{{ lroute('authors.show', $article->author) }}" class="mt-1 block text-lg font-bold text-navy-900 hover:text-turquoise-700">{{ $article->author->name }}</a>
                        @if ($article->author->title)
                            <p class="text-sm text-navy-500">{{ $article->author->title }}</p>
                        @endif
                        @if ($article->author->bio_html)
                            <div class="prose prose-sm mt-3 max-w-none text-sm leading-relaxed text-navy-700 [&_a]:text-turquoise-700 [&_a]:underline [&_h2]:mt-3 [&_h2]:text-base [&_h2]:font-semibold [&_h3]:mt-3 [&_h3]:font-semibold [&_ol]:list-decimal [&_ol]:pl-5 [&_p+p]:mt-2 [&_ul]:list-disc [&_ul]:pl-5 [&_blockquote]:border-l-2 [&_blockquote]:border-turquoise-300 [&_blockquote]:pl-3 [&_blockquote]:italic">
                                {!! $article->author->bio_html !!}
                            </div>
                        @endif
                    </div>
                </div>
            </aside>
        @endif
    </x-container>
</x-layout>
