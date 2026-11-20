<x-layout :title="__('Vatandaş Rehberi')">
    <x-container class="py-12">
        <nav class="mb-8 text-sm text-navy-500" aria-label="{{ __('Sayfa konumu') }}">
            <a href="{{ lroute('home') }}" class="hover:text-turquoise-700">{{ __('Ana Sayfa') }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-navy-800">{{ __('Vatandaş Rehberi') }}</span>
        </nav>

        <x-section-heading :eyebrow="__('Vatandaş Rehberi')" :title="__('Vatandaş Rehberi')" :hint="__('Belediye hizmetleri ve haklarınız hakkında bilmeniz gerekenler')" />

        <div class="mt-8 flex flex-wrap gap-2" role="tablist" aria-label="{{ __('Kategori filtresi') }}">
            @foreach ($tabs as $key => $label)
                @php $isActive = ($key === '' ? null : $key) === $activeTab; @endphp
                <a
                    href="{{ lroute('citizen-guide.index', $key === '' ? [] : ['kategori' => $key]) }}"
                    role="tab"
                    aria-selected="{{ $isActive ? 'true' : 'false' }}"
                    @class([
                        'rounded-full border px-4 py-2 text-sm font-medium transition',
                        'border-[#8b1e3f] bg-[#8b1e3f] text-white' => $isActive,
                        'border-navy-100 bg-white text-navy-700 hover:border-[#8b1e3f] hover:text-[#8b1e3f]' => ! $isActive,
                    ])
                >{{ $label }}</a>
            @endforeach
        </div>

        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($articles as $article)
                <x-card class="flex h-full flex-col overflow-hidden">
                    @if ($article->featured_image)
                        <a href="{{ lroute('articles.show', $article) }}" tabindex="-1" aria-hidden="true">
                            <img src="{{ asset('storage/'.$article->featured_image) }}" alt="" loading="lazy" class="h-40 w-full object-cover" />
                        </a>
                    @endif
                    <div class="flex flex-1 flex-col gap-3 p-5">
                        @if ($article->category)
                            <span class="text-[11px] font-semibold uppercase tracking-wide text-turquoise-700">{{ $article->category->name }}</span>
                        @endif
                        <h2 class="text-lg font-semibold text-navy-900">
                            <a href="{{ lroute('articles.show', $article) }}" class="hover:text-turquoise-700">{{ $article->title }}</a>
                        </h2>
                        <p class="flex-1 text-sm text-navy-600">{{ $article->lead }}</p>
                        <div class="flex items-center justify-between border-t border-navy-100 pt-3 text-xs text-navy-500">
                            @if ($article->author)
                                <a href="{{ lroute('authors.show', $article->author) }}" class="flex min-w-0 items-center gap-2 font-medium text-navy-700 hover:text-turquoise-700">
                                    <x-author-avatar :author="$article->author" size="sm" />
                                    <span class="truncate">{{ $article->author->name }}</span>
                                </a>
                            @else
                                <span></span>
                            @endif
                            <span class="flex items-center gap-2">
                                <time datetime="{{ $article->published_at }}">{{ $article->published_at?->translatedFormat('d F Y') }}</time>
                                <span aria-hidden="true">&middot;</span>
                                <span class="font-medium">{{ $article->reading_time }}</span>
                            </span>
                        </div>
                    </div>
                </x-card>
            @empty
                <p class="col-span-full rounded-lg border border-navy-100 bg-navy-50 p-6 text-navy-600">{{ __('Bu kategoride henüz içerik yayımlanmadı.') }}</p>
            @endforelse
        </div>

        <div class="mt-10">{{ $articles->links() }}</div>
    </x-container>
</x-layout>
