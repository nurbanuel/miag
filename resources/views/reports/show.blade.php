<x-layout :title="$report->title">
    <x-container class="py-12">
        <nav class="mb-6 text-sm text-navy-500">
            <a href="{{ lroute('reports.index') }}" class="hover:text-turquoise-700">{{ __('Rapor ve Analizler') }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-navy-800">{{ $report->title }}</span>
        </nav>

        <div class="grid gap-10 lg:grid-cols-[2fr_1fr]">
            <article>
                @if ($report->featured_image)
                    <img src="{{ asset('storage/'.$report->featured_image) }}" alt="{{ $report->title }}" class="mb-6 h-auto w-full rounded-xl object-contain" />
                @endif

                <div class="flex flex-wrap items-center gap-2">
                    <x-badge tone="turquoise">{{ $report->type_label }}</x-badge>
                    @if ($report->category)
                        <x-badge tone="navy">{{ $report->category->name }}</x-badge>
                    @endif
                </div>
                <h1 class="mt-3 text-3xl font-bold text-navy-900">{{ $report->title }}</h1>
                <p class="mt-2 text-sm text-navy-500">{{ __('Yayım Tarihi') }}: {{ $report->published_at?->translatedFormat('d F Y') }}</p>

                @if ($report->spot)
                    <p class="mt-6 text-lg font-medium leading-relaxed text-navy-800">{{ $report->spot }}</p>
                @endif

                @if ($report->summary && $report->summary !== $report->spot)<h2 class="mt-8 text-xl font-bold text-navy-900">{{ __('Yönetici Özeti') }}</h2>@endif
                @if ($report->summary && $report->summary !== $report->spot)
                    <p class="mt-3 leading-relaxed text-navy-700">{{ $report->summary }}</p>
                @endif

                @if ($report->content)
                    <div class="prose max-w-none prose-p:my-4 prose-p:leading-relaxed prose-headings:text-navy-900 prose-a:text-turquoise-700 prose-strong:text-navy-900 leading-relaxed text-navy-700 mt-6">{!! $report->content !!}</div>
                @endif

                @if ($report->key_findings)
                    <h2 class="mt-8 text-xl font-bold text-navy-900">{{ __('Temel Bulgular') }}</h2>
                    <ul class="mt-3 space-y-2">
                        @foreach (explode("\n", $report->key_findings) as $finding)
                            @if (trim($finding) !== '')
                                <li class="flex items-start gap-2 text-navy-700">
                                    <svg class="mt-1 h-3.5 w-3.5 shrink-0 text-turquoise-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><circle cx="10" cy="10" r="5" /></svg>
                                    {{ $finding }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif

                <div class="mt-8 rounded-lg border border-navy-100 bg-navy-50 p-5 text-sm text-navy-600">
                    <p class="font-semibold text-navy-800">{{ __('Künye') }}</p>
                    <p class="mt-1">{{ __('Yayıncı') }}: MİARGEM</p>
                    <p>{{ __('Tür') }}: {{ __($report->sub_category ?: 'Rapor') }}</p>
                    <p>{{ __('Kategori') }}: {{ $report->category?->name }}</p>
                    <p>{{ __('Yayım Tarihi') }}: {{ $report->published_at?->translatedFormat('d F Y') }}</p>
                </div>
            </article>

            <aside>
                <div class="rounded-xl border border-navy-100 p-6">
                    <h3 class="font-semibold text-navy-900">{{ __('Raporu İndir') }}</h3>
                    <p class="mt-2 text-sm text-navy-600">{{ __('Tam metin PDF olarak indirilebilir.') }}</p>
                    <x-button href="{{ $report->file_path ? asset('storage/'.$report->file_path) : '#' }}" variant="turquoise" class="mt-4 w-full justify-center">
                        {{ __('PDF İndir') }}
                    </x-button>
                </div>
            </aside>
        </div>
    </x-container>
</x-layout>
