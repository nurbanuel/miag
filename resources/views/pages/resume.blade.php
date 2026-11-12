<x-layout title="{{ __('Özgeçmiş') }}">
    <x-container class="py-12">
        <nav class="mb-8 text-sm text-navy-500" aria-label="{{ __('Sayfa konumu') }}">
            <a href="{{ lroute('home') }}" class="hover:text-turquoise-700">{{ __('Ana Sayfa') }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-navy-800">{{ __('Özgeçmiş') }}</span>
        </nav>

        <h1 class="text-3xl font-bold text-navy-900 md:text-4xl">{{ __('Özgeçmiş') }}</h1>
        <div class="mt-3 h-1 w-16 rounded-full bg-turquoise-600"></div>

        @if ($resume)
            <div class="mt-10 grid gap-10 lg:grid-cols-[16rem_1fr] lg:gap-14">
                <aside class="flex flex-col items-center lg:items-start">
                    <div class="lg:sticky lg:top-28">
                        @if ($resume->image)
                            <img
                                src="{{ asset('storage/'.$resume->image) }}"
                                alt="{{ $resume->full_name }}"
                                class="h-80 w-64 rounded-lg object-cover shadow-md ring-1 ring-navy-100"
                            />
                        @else
                            <div class="flex h-80 w-64 items-center justify-center rounded-lg bg-navy-50 text-navy-500 shadow-md ring-1 ring-navy-100">
                                <svg class="h-20 w-20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z" /></svg>
                            </div>
                        @endif

                        <div class="mt-5 w-64 border-l-4 border-turquoise-600 pl-4">
                            <h2 class="text-lg font-bold text-navy-900">{{ $resume->full_name }}</h2>
                            @if ($resume->title)
                                <p class="mt-1 text-sm text-navy-500">{{ $resume->title }}</p>
                            @endif
                        </div>
                    </div>
                </aside>

                <article
                    class="prose prose-lg max-w-none leading-relaxed text-navy-700
                        [&_p]:mb-5 [&_a]:text-turquoise-700 [&_a]:underline
                        [&_h2]:mb-3 [&_h2]:mt-8 [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-navy-900
                        [&_h3]:mb-2 [&_h3]:mt-6 [&_h3]:text-xl [&_h3]:font-semibold [&_h3]:text-navy-900
                        [&_ul]:mb-5 [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:mb-5 [&_ol]:list-decimal [&_ol]:pl-6 [&_li]:mb-1
                        [&_blockquote]:my-6 [&_blockquote]:border-l-4 [&_blockquote]:border-turquoise-600 [&_blockquote]:pl-4 [&_blockquote]:italic
                        [&_strong]:font-semibold [&_strong]:text-navy-900"
                >
                    {!! $resume->content !!}
                </article>
            </div>
        @else
            <p class="mt-10 text-navy-500">{{ __('Özgeçmiş henüz yayımlanmamıştır.') }}</p>
        @endif
    </x-container>
</x-layout>
