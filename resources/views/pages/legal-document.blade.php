<x-layout :title="$document->title">
    <div class="border-b border-navy-100 bg-navy-50/60">
        <x-container class="py-10 sm:py-12">
            <nav class="mb-4 text-sm text-navy-500" aria-label="{{ __('Sayfa konumu') }}">
                <a href="{{ lroute('home') }}" class="hover:text-turquoise-700">{{ __('Ana Sayfa') }}</a>
                <span class="mx-1.5">/</span>
                <span class="text-navy-800">{{ $document->title }}</span>
            </nav>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-turquoise-700">{{ __('Yasal Metinler') }}</p>
            <h1 class="mt-2 text-3xl font-bold text-navy-900 sm:text-4xl">{{ $document->title }}</h1>
            <div class="mt-4 h-1 w-16 rounded-full bg-[#8b1e3f]"></div>
        </x-container>
    </div>

    <x-container class="py-10 sm:py-14">
        <article
            class="prose prose-slate max-w-4xl leading-relaxed text-navy-700
                prose-headings:text-navy-900 prose-h2:mt-10 prose-h2:border-b prose-h2:border-navy-100 prose-h2:pb-2 prose-h2:text-2xl
                prose-h3:mt-6 prose-h3:text-lg prose-h3:text-navy-800
                prose-p:my-3 prose-p:leading-relaxed prose-strong:text-navy-900 prose-a:text-turquoise-700
                prose-ul:list-none prose-ul:pl-0 prose-li:my-1.5 prose-li:pl-0
                prose-table:my-6 prose-table:w-full prose-table:border prose-table:border-navy-200 prose-table:text-sm
                prose-th:border prose-th:border-navy-200 prose-th:bg-slate-100 prose-th:p-3 prose-th:text-left prose-th:text-navy-900
                prose-td:border prose-td:border-navy-200 prose-td:p-3"
        >
            <div class="overflow-x-auto">
                {!! $document->content !!}
            </div>
        </article>

        <p class="mt-10 max-w-4xl border-t border-navy-100 pt-6 text-xs text-navy-500">
            {{ __('Son düzenleme') }}: {{ $document->updated_at?->translatedFormat('d F Y') }}
        </p>
    </x-container>
</x-layout>
