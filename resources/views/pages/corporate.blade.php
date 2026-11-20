@php
// Banner: "Sayfalar > Kurumsal" kaydı; boşsa Site Ayarları'ndaki yedek başlıklar.
$pageTitle = $page?->banner_title ?: ($siteSettings?->corporate_page_title ?: 'MİARGEM Kurumsal');
$pageSubtitle = $page?->banner_subtitle ?: $siteSettings?->corporate_page_subtitle;
$pageDescription = $page?->banner_description;

$h2 = 'text-2xl font-bold text-teal-700';
$prose = 'max-w-none text-gray-700 leading-relaxed space-y-4 [&_h3]:text-lg [&_h3]:font-semibold [&_h3]:text-gray-900 [&_h3+p]:!mt-3 [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5 [&_a]:text-teal-700 [&_a]:underline';
$card = 'rounded-lg border border-gray-200 bg-white p-6 shadow-sm';
$details = 'group rounded-lg border border-gray-200 bg-white shadow-sm open:shadow-md';
$summary = 'flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 font-semibold text-gray-900 hover:text-teal-700 [&::-webkit-details-marker]:hidden';
$chevron = '<svg class="h-5 w-5 shrink-0 text-teal-700 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" /></svg>';
// Akordeon gövdesindeki zengin metin: liste maddeleri ve ara başlıklar (ör. 7.1, 7.2) mevcut tipografiyle.
$accordionBody = 'space-y-4 border-t border-gray-100 px-5 py-4 text-gray-700 leading-relaxed [&_ul]:mt-4 [&_ul]:space-y-3 [&_strong]:font-semibold [&_strong]:text-gray-900 [&_h3]:font-semibold [&_h3]:text-teal-700 [&_h3+p]:!mt-2 [&_h3+p]:text-sm [&_a]:text-teal-700 [&_a]:underline';

$filled = fn ($v) => filled(trim(strip_tags((string) $v)));
@endphp

<x-layout :title="$page?->title ?: 'Kurumsal'">
    <div class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
        <nav class="mb-6 text-sm text-gray-500" aria-label="{{ __('Sayfa konumu') }}">
            <a href="{{ lroute('home') }}" class="hover:text-teal-700">{{ __('Ana Sayfa') }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-gray-800">{{ __('Kurumsal') }}</span>
        </nav>

        <header class="mb-12 border-b border-gray-200 pb-8">
            <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">{{ $pageTitle }}</h1>
            @if (filled($pageSubtitle))
                <p class="mt-2 text-lg text-teal-700">{{ $pageSubtitle }}</p>
            @endif
            @if (filled($pageDescription))
                <p class="mt-4 max-w-3xl leading-relaxed text-gray-600">{{ $pageDescription }}</p>
            @endif
        </header>

        <div class="flex flex-col gap-12 lg:flex-row">
            {{-- Sol kolon: İçindekiler --}}
            <aside class="lg:sticky lg:top-24 lg:h-max lg:w-1/4">
                @if ($sections->isNotEmpty())
                    <nav aria-label="İçindekiler" class="rounded-lg border border-gray-200 bg-gray-50 p-5">
                        <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">İçindekiler</p>
                        <ol class="space-y-1 text-sm">
                            @foreach ($sections as $section)
                                <li>
                                    <a href="#{{ $section->slug }}" class="flex gap-2 rounded-md px-2 py-1.5 text-gray-700 hover:bg-white hover:text-teal-700">
                                        <span class="w-5 shrink-0 text-right font-semibold text-teal-700">{{ $loop->iteration }}.</span>
                                        <span>{{ $section->title }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                @endif

                @if (filled($siteSettings?->contact_email) || filled($siteSettings?->contact_phone) || filled($siteSettings?->contact_address))
                    <div id="iletisim" class="mt-6 scroll-mt-24 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="font-semibold text-gray-900">{{ __('İletişim') }}</p>
                        @if (filled($siteSettings->contact_email))
                            <p class="mt-2 text-sm text-gray-600"><a href="mailto:{{ $siteSettings->contact_email }}" class="hover:text-teal-700">{{ $siteSettings->contact_email }}</a></p>
                        @endif
                        @if (filled($siteSettings->contact_phone))
                            <p class="mt-1 text-sm text-gray-600"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings->contact_phone) }}" class="hover:text-teal-700">{{ $siteSettings->contact_phone }}</a></p>
                        @endif
                        @if (filled($siteSettings->contact_address))
                            <p class="mt-1 whitespace-pre-line text-sm text-gray-600">{{ $siteSettings->contact_address }}</p>
                        @endif
                    </div>
                @endif
            </aside>

            {{-- Sağ kolon: İçerik --}}
            <div class="space-y-16 lg:w-3/4">
                @foreach ($sections as $section)
                    @php $items = collect($section->items ?? []); @endphp

                    <section id="{{ $section->slug }}" class="scroll-mt-24">
                        <h2 class="{{ $h2 }}">{{ $section->title }}</h2>

                        @switch($section->display_type)
                            {{-- Misyon, Vizyon ve Öncelikler --}}
                            @case('mission_vision')
                                @if ($filled($section->content))
                                    <div class="{{ $prose }} mt-6">{!! $section->content !!}</div>
                                @endif

                                @php
                                    // Ardışık öğeler türüne göre gruplanır:
                                    // yalnızca başlık = ara başlık, başlık + açıklama = kart, vurgu etiketi + açıklama = öncelik maddesi.
                                    $groups = [];
                                    foreach ($items as $item) {
                                        $kind = filled($item['subtitle'] ?? null) ? 'priority' : ($filled($item['description'] ?? null) ? 'card' : 'heading');
                                        $last = array_key_last($groups);
                                        if ($last !== null && $kind !== 'heading' && $groups[$last]['kind'] === $kind) {
                                            $groups[$last]['items'][] = $item;
                                        } else {
                                            $groups[] = ['kind' => $kind, 'items' => [$item]];
                                        }
                                    }
                                @endphp

                                @foreach ($groups as $group)
                                    @if ($group['kind'] === 'heading')
                                        <h3 class="mt-10 text-lg font-semibold text-gray-900">{{ $group['items'][0]['title'] ?? '' }}</h3>
                                    @elseif ($group['kind'] === 'card')
                                        <div class="mt-8 grid gap-6 md:grid-cols-2">
                                            @foreach ($group['items'] as $item)
                                                <div class="{{ $card }} border-t-4 border-t-teal-600">
                                                    <h3 class="text-lg font-semibold text-teal-700">{{ $item['title'] ?? '' }}</h3>
                                                    <div class="mt-3 space-y-3 text-sm leading-relaxed text-gray-700">{!! $item['description'] !!}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                            @foreach ($group['items'] as $item)
                                                <div class="flex gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-teal-50 text-sm font-bold text-teal-700">{{ $item['subtitle'] }})</span>
                                                    <div class="text-sm leading-relaxed text-gray-700">
                                                        @if (filled($item['title'] ?? null))
                                                            <p class="font-semibold text-gray-900">{{ $item['title'] }}</p>
                                                        @endif
                                                        {!! $item['description'] ?? '' !!}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                                @break

                            {{-- Kart Izgarası --}}
                            @case('cards')
                                @if ($filled($section->content))
                                    <div class="{{ $prose }} mt-4">{!! $section->content !!}</div>
                                @endif
                                @if ($items->isNotEmpty())
                                    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                        @foreach ($items as $item)
                                            <div class="{{ $card }} transition hover:border-teal-300 hover:shadow-md">
                                                @if (filled($item['subtitle'] ?? null))
                                                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $item['subtitle'] }}</p>
                                                @endif
                                                <h3 class="font-semibold text-teal-700">{{ $item['title'] ?? '' }}</h3>
                                                <div class="mt-2 space-y-2 text-sm leading-relaxed text-gray-700">{!! $item['description'] ?? '' !!}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @break

                            {{-- Akordeon Alt Başlıklar --}}
                            @case('accordion')
                                @if ($filled($section->content))
                                    <div class="{{ $prose }} mt-4">{!! $section->content !!}</div>
                                @endif
                                @if ($items->isNotEmpty())
                                    <div class="mt-6 space-y-3">
                                        @foreach ($items as $item)
                                            <details class="{{ $details }}" @if ($loop->first) open @endif>
                                                <summary class="{{ $summary }}">
                                                    <span>{{ $item['title'] ?? '' }}@if (filled($item['subtitle'] ?? null)) <span class="ml-2 text-sm font-normal text-gray-500">{{ $item['subtitle'] }}</span>@endif</span>
                                                    {!! $chevron !!}
                                                </summary>
                                                <div class="{{ $accordionBody }}">{!! $item['description'] ?? '' !!}</div>
                                            </details>
                                        @endforeach
                                    </div>
                                @endif
                                @break

                            {{-- Danışma Kurulu ve Kadro Listesi --}}
                            @case('team')
                                @if ($filled($section->content))
                                    <div class="{{ $prose }} mt-4">{!! $section->content !!}</div>
                                @endif
                                @if ($items->isNotEmpty())
                                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                                        @foreach ($items as $item)
                                            <div class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-teal-50 text-teal-700" aria-hidden="true">
                                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z" /></svg>
                                                </span>
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $item['title'] ?? '' }}</p>
                                                    @if (filled($item['subtitle'] ?? null))
                                                        <p class="text-sm text-gray-600">{{ $item['subtitle'] }}</p>
                                                    @endif
                                                    @if ($filled($item['description'] ?? null))
                                                        <div class="mt-1 text-sm text-gray-600">{!! $item['description'] !!}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @break

                            {{-- Standart Metin --}}
                            @default
                                @foreach ($items as $item)
                                    @if (filled($item['title'] ?? null))
                                        <p class="mt-2 font-semibold text-gray-900">{{ $item['title'] }}@if (filled($item['subtitle'] ?? null)) <span class="font-normal text-gray-600">— {{ $item['subtitle'] }}</span>@endif</p>
                                    @endif
                                    @if ($filled($item['description'] ?? null))
                                        <div class="mt-2 text-gray-700 leading-relaxed">{!! $item['description'] !!}</div>
                                    @endif
                                @endforeach
                                @if ($filled($section->content))
                                    <div class="{{ $prose }} mt-4">{!! $section->content !!}</div>
                                @endif
                        @endswitch
                    </section>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>
