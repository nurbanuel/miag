<x-layout title="Rapor ve Analizler">
    <x-container class="py-12">
        <x-section-heading eyebrow="Rapor ve Analizler" :title="__('Rapor ve Analizler')" :hint="__('Yerel yönetimler için üretilen araştırma çıktılarını filtreleyin ve inceleyin.')" />

        <form action="{{ lroute('reports.index') }}" method="GET" class="mt-8 flex flex-wrap gap-3">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ __('Raporlarda ara...') }}" class="w-full max-w-sm rounded-md border border-navy-200 px-3.5 py-2.5 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-turquoise-500" />
            <select name="category" class="rounded-md border border-navy-200 bg-white px-3.5 py-2.5 text-sm">
                <option value="">{{ __('Tüm Kategoriler') }}</option>
                @foreach ($categories as $categoryId => $categoryName)
                    <option value="{{ $categoryId }}" @selected((int) request('category') === $categoryId)>{{ $categoryName }}</option>
                @endforeach
            </select>
            <x-button type="submit" variant="navy">{{ __('Filtrele') }}</x-button>
        </form>

        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($reports as $report)
                @php
                    $coverBg = ['navy' => 'bg-navy-900', 'turquoise' => 'bg-turquoise-600', 'bordo' => 'bg-bordo-600'][$report->cover_color] ?? 'bg-turquoise-600';
                    $badgeTone = $report->cover_color === 'bordo' ? 'bordo' : ($report->cover_color === 'navy' ? 'navy' : 'turquoise');
                @endphp
                <x-card class="flex flex-col overflow-hidden">
                    <div class="flex h-28 items-center justify-center {{ $coverBg }}">
                        <svg class="h-10 w-10 text-white/90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M9 8h1M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H9.828a2 2 0 00-1.414.586L5.586 7.414A2 2 0 005 8.828V18a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="flex flex-1 flex-col gap-3 p-5">
                        <x-badge :tone="$badgeTone">{{ $report->category?->name }}</x-badge>
                        <h2 class="text-lg font-semibold text-navy-900">
                            <a href="{{ lroute('reports.show', $report) }}" class="hover:text-turquoise-700">{{ $report->title }}</a>
                        </h2>
                        <p class="flex-1 text-sm text-navy-600">{{ $report->summary }}</p>
                        <a href="{{ lroute('reports.show', $report) }}" class="text-sm font-semibold text-turquoise-700 hover:underline">{{ __('Raporu İncele') }} →</a>
                    </div>
                </x-card>
            @empty
                <p class="col-span-full rounded-lg border border-navy-100 bg-navy-50 p-6 text-navy-600">{{ __('Kriterlere uygun rapor bulunamadı.') }}</p>
            @endforelse
        </div>

        <div class="mt-10">{{ $reports->links() }}</div>
    </x-container>
</x-layout>
