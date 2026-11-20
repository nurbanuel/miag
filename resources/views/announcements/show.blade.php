<x-layout :title="$announcement->title">
    <x-container class="max-w-3xl py-12">
        <nav aria-label="{{ __('Sayfa konumu') }}" class="mb-6 text-sm text-navy-500">
            <a href="{{ lroute('home') }}" class="hover:text-turquoise-700">{{ __('Ana Sayfa') }}</a>
            <span class="mx-1.5" aria-hidden="true">/</span>
            <span>{{ __('Duyurular') }}</span>
            <span class="mx-1.5" aria-hidden="true">/</span>
            <span class="text-navy-800">{{ $announcement->title }}</span>
        </nav>

        @if ($announcement->featured_image)
            <img src="{{ asset('storage/'.$announcement->featured_image) }}" alt="{{ $announcement->title }}" class="mb-6 h-auto w-full rounded-xl object-contain" />
        @endif

        @if ($label = $announcement->category?->name ?? $announcement->category_label)
            <x-badge tone="turquoise">{{ $label }}</x-badge>
        @endif
        <h1 class="mt-3 text-3xl font-bold text-navy-900">{{ $announcement->title }}</h1>
        <p class="mt-2 text-sm text-navy-500">{{ $announcement->created_at?->translatedFormat('d F Y') }}</p>

        @if ($announcement->lead)
            <p class="mt-6 text-lg font-medium leading-relaxed text-navy-800">{{ $announcement->lead }}</p>
        @endif

        @if (filled($announcement->content))
            <div class="prose max-w-none prose-p:my-4 prose-p:leading-relaxed prose-headings:text-navy-900 prose-a:text-turquoise-700 prose-strong:text-navy-900 leading-relaxed text-navy-700 mt-6">
                {!! $announcement->content !!}
            </div>
        @endif

        {{-- Duyurunun yönlendirdiği ilgili sayfa (varsa) --}}
        @if ($announcement->url)
            <x-button :href="$announcement->url" variant="primary" class="mt-8">{{ __('İlgili sayfaya git') }} →</x-button>
        @endif
    </x-container>
</x-layout>
