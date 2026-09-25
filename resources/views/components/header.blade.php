@php
$locale = app()->getLocale();
$menuItems = $siteSettings->header_menu ?? [];
$localeHref = fn (string $url) => ($locale === 'en' ? '/en' : '').$url;
@endphp

<header x-data="{ mobileOpen: false, searchOpen: false }" @keydown.escape.window="searchOpen = false">
    <a href="#main-content" class="skip-link">{{ $locale === 'tr' ? 'İçeriğe geç' : 'Skip to content' }}</a>

    {{-- 1. Üst Bilgi Şeridi --}}
    <div class="bg-[#061024] text-slate-300">
        <x-container class="flex h-9 flex-wrap items-center justify-between gap-x-4 gap-y-1 text-xs">
            <p class="truncate">{{ __('Mahallî idareler için bağımsız araştırma ve politika merkezi') }}</p>

            <div class="flex items-center gap-3">
                <a href="{{ lroute('participation.index') }}" class="hidden hover:text-white sm:inline">{{ __('Katılım') }}</a>
                <span aria-hidden="true" class="hidden text-slate-600 sm:inline">&middot;</span>
                <a href="#newsletter-signup" class="hidden hover:text-white sm:inline">{{ __('Bülten') }}</a>
                <span aria-hidden="true" class="hidden text-slate-600 sm:inline">&middot;</span>
                <a href="{{ lroute('corporate') }}#iletisim" class="hidden hover:text-white sm:inline">{{ __('İletişim') }}</a>

                <div class="ml-1 flex items-center gap-1 rounded-full border border-white/15 p-0.5 font-semibold">
                    <a href="{{ lroute('home') }}" class="rounded-full px-2 py-0.5 {{ $locale === 'tr' ? 'bg-white text-[#061024]' : 'text-slate-300 hover:text-white' }}">TR</a>
                    <a href="{{ route('en.home') }}" class="rounded-full px-2 py-0.5 {{ $locale === 'en' ? 'bg-white text-[#061024]' : 'text-slate-300 hover:text-white' }}">EN</a>
                </div>
            </div>
        </x-container>
    </div>

    {{-- 2. Ana Navigasyon Şeridi --}}
    <div class="relative z-40 border-b border-slate-100 bg-white">
        <x-container class="flex h-20 items-center justify-between gap-6">
            {{-- Logo --}}
            <a href="{{ lroute('home') }}" class="flex shrink-0 items-center">
                <img src="{{ asset('images/logo.png') }}" alt="{{ __('MİARGEM - Mahalli İdareler Araştırma ve Geliştirme Merkezi') }}" class="h-11 w-auto sm:h-12" />
            </a>

            {{-- Ana menü --}}
            <nav aria-label="Ana menü" class="hidden items-center gap-1 lg:flex">
                @foreach ($menuItems as $item)
                    @if (! empty($item['children']))
                        {{-- Alt menülü öğe: bordo vurgulu dropdown --}}
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button
                                type="button"
                                class="flex items-center gap-1 rounded-md px-3 py-2 text-sm font-semibold text-[#8b1e3f] hover:bg-bordo-50 hover:text-[#721833]"
                                @click="open = !open"
                                :aria-expanded="open.toString()"
                                aria-haspopup="true"
                            >
                                {{ $item['title'] }}
                                <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" /></svg>
                            </button>
                            <div x-show="open" x-cloak x-transition class="absolute left-0 top-full w-72 rounded-lg border border-slate-100 bg-white p-2 text-slate-900 shadow-lg">
                                <a href="{{ $localeHref($item['url']) }}" class="block rounded-md px-3 py-2 text-sm font-semibold text-[#8b1e3f] hover:bg-bordo-50">
                                    {{ $item['title'] }} — {{ __('Genel Bakış') }}
                                </a>
                                <div class="my-1 border-t border-slate-100"></div>
                                @foreach ($item['children'] as $child)
                                    <a href="{{ $localeHref($child['url']) }}" class="block rounded-md px-3 py-2 text-sm hover:bg-slate-50">
                                        {{ $child['title'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $localeHref($item['url']) }}" class="rounded-md px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-[#061024]">
                            {{ $item['title'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            {{-- Arama + Katılım --}}
            <div class="hidden items-center gap-3 lg:flex">
                <div class="relative">
                    <button
                        type="button"
                        @click="searchOpen = !searchOpen"
                        :aria-expanded="searchOpen.toString()"
                        aria-controls="desktop-search-panel"
                        aria-label="{{ __('Ara') }}"
                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:border-slate-300 hover:text-[#061024]"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                    </button>

                    <div
                        id="desktop-search-panel"
                        x-show="searchOpen"
                        x-cloak
                        x-transition
                        @click.outside="searchOpen = false"
                        class="absolute right-0 top-full mt-2 w-80 rounded-lg border border-slate-100 bg-white p-3 shadow-lg"
                    >
                        <form action="{{ lroute('search') }}" method="GET" role="search">
                            <label for="desktop-search" class="sr-only">{{ __('Ara') }}</label>
                            <input
                                id="desktop-search"
                                type="search"
                                name="q"
                                x-ref="desktopSearchInput"
                                x-init="$watch('searchOpen', (open) => open && $nextTick(() => $refs.desktopSearchInput.focus()))"
                                placeholder="{{ __('Rapor, yazı, mevzuat, haber veya etkinlik ara...') }}"
                                class="w-full rounded-md border border-slate-200 px-3.5 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-turquoise-500"
                            />
                        </form>
                    </div>
                </div>

                <a href="{{ lroute('participation.index') }}" class="rounded-lg bg-[#8b1e3f] px-5 py-2 text-sm font-medium text-white hover:bg-[#721833]">
                    {{ __('Katılım') }}
                </a>
            </div>

            {{-- Mobil hamburger --}}
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-md p-2 text-[#061024] lg:hidden"
                @click="mobileOpen = !mobileOpen"
                :aria-expanded="mobileOpen.toString()"
                aria-controls="mobile-menu"
                :aria-label="mobileOpen ? '{{ $locale === 'tr' ? 'Menüyü kapat' : 'Close menu' }}' : '{{ $locale === 'tr' ? 'Menüyü aç' : 'Open menu' }}'"
            >
                <svg x-show="!mobileOpen" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                <svg x-show="mobileOpen" x-cloak class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </x-container>
    </div>

    {{-- Mobil menü paneli --}}
    <div id="mobile-menu" x-show="mobileOpen" x-cloak x-transition class="border-b border-slate-100 bg-white lg:hidden">
        <x-container class="flex flex-col gap-1 py-4">
            <form action="{{ lroute('search') }}" method="GET" role="search" class="mb-3">
                <label for="mobile-search" class="sr-only">{{ __('Ara') }}</label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                    <input id="mobile-search" type="search" name="q" placeholder="{{ __('Ara') }}..." class="w-full rounded-lg border border-slate-200 py-2 pl-9 pr-4 text-sm text-slate-900 placeholder:text-slate-400" />
                </div>
            </form>

            @foreach ($menuItems as $item)
                @if (! empty($item['children']))
                    <div x-data="{ open: false }">
                        <button type="button" @click="open = !open" :aria-expanded="open.toString()" class="flex w-full items-center justify-between rounded-md px-3 py-2.5 text-sm font-semibold text-[#8b1e3f] hover:bg-bordo-50">
                            {{ $item['title'] }}
                            <svg class="h-4 w-4 transition-transform" :class="open && 'rotate-180'" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" /></svg>
                        </button>
                        <div x-show="open" x-cloak x-transition class="ml-4 flex flex-col border-l border-slate-100 pl-3">
                            @foreach ($item['children'] as $child)
                                <a href="{{ $localeHref($child['url']) }}" class="rounded-md px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-[#8b1e3f]">{{ $child['title'] }}</a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $localeHref($item['url']) }}" class="rounded-md px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">{{ $item['title'] }}</a>
                @endif
            @endforeach

            <a href="{{ lroute('participation.index') }}" class="mt-3 rounded-lg bg-[#8b1e3f] px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-[#721833]">
                {{ __('Katılım') }}
            </a>
        </x-container>
    </div>
</header>
