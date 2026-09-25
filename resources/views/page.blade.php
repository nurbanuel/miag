<x-layout :title="$page->title">
    @if ($page->banner_title || $page->banner_subtitle || $page->banner_description)
        <section class="bg-navy-950 py-16 text-white">
            <x-container>
                @if ($page->banner_title)
                    <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-turquoise-400">{{ $page->banner_title }}</p>
                @endif
                @if ($page->banner_subtitle)
                    <h1 class="max-w-2xl text-3xl font-bold sm:text-4xl">{{ $page->banner_subtitle }}</h1>
                @endif
                @if ($page->banner_description)
                    <p class="mt-4 max-w-2xl text-white/75">{{ $page->banner_description }}</p>
                @endif
            </x-container>
        </section>
    @else
        <x-container class="pt-12">
            <h1 class="text-3xl font-bold text-navy-900">{{ $page->title }}</h1>
        </x-container>
    @endif

    <x-container class="grid gap-12 py-16 lg:grid-cols-3">
        <div class="prose prose-navy max-w-none lg:col-span-2">
            {!! $page->content !!}
        </div>

        @if ($page->sidebar_content)
            <div class="prose prose-navy max-w-none">
                {!! $page->sidebar_content !!}
            </div>
        @endif
    </x-container>
</x-layout>
