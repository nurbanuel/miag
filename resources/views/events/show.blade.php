<x-layout :title="$event->title">
    <x-container class="py-12">
        <nav class="mb-6 text-sm text-navy-500">
            <a href="{{ lroute('events.index') }}" class="hover:text-turquoise-700">{{ __('Etkinlikler') }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-navy-800">{{ $event->title }}</span>
        </nav>

        <div class="grid gap-10 lg:grid-cols-[2fr_1fr]">
            <article>
                @if ($event->featured_image)
                    <img src="{{ asset('storage/'.$event->featured_image) }}" alt="{{ $event->title }}" class="mb-6 h-auto w-full rounded-xl object-contain" />
                @endif

                @if ($event->is_past)
                    <x-badge tone="navy">{{ __('Geçmiş Etkinlik') }}</x-badge>
                @else
                    <x-badge tone="turquoise">{{ __('Yaklaşan Etkinlik') }}</x-badge>
                @endif
                <h1 class="mt-3 text-3xl font-bold text-navy-900">{{ $event->title }}</h1>
                @if ($event->spot)
                    <p class="mt-4 text-lg font-medium leading-relaxed text-navy-800">{{ $event->spot }}</p>
                @endif
                <div class="prose max-w-none prose-p:my-4 prose-p:leading-relaxed prose-headings:text-navy-900 prose-a:text-turquoise-700 prose-strong:text-navy-900 leading-relaxed text-navy-700 mt-4">{!! $event->description !!}</div>

                @if (!empty($event->speakers))
                    <h2 class="mt-8 text-lg font-bold text-navy-900">{{ __('Konuşmacılar') }}</h2>
                    <ul class="mt-3 flex flex-wrap gap-2">
                        @foreach ($event->speakers as $speaker)
                            <li class="rounded-full bg-navy-50 px-3 py-1 text-sm text-navy-700">{{ $speaker }}</li>
                        @endforeach
                    </ul>
                @endif
            </article>

            <aside>
                <div class="rounded-xl border border-navy-100 p-6">
                    <p class="text-sm font-semibold text-navy-500">{{ __('Tarih') }}</p>
                    <p class="mt-1 text-navy-900">{{ $event->starts_at->translatedFormat('d F Y, H:i') }}</p>
                    <p class="mt-4 text-sm font-semibold text-navy-500">{{ __('Yer') }}</p>
                    <p class="mt-1 text-navy-900">{{ $event->location }}</p>

                    @if ($event->isRegistrationOpen())
                        <x-button :href="lroute('events.register', $event)" variant="primary" class="mt-6 w-full justify-center">{{ __('Etkinliğe Kayıt Ol') }}</x-button>
                    @elseif (! $event->is_past)
                        <p class="mt-6 rounded-lg bg-navy-50 px-4 py-3 text-center text-sm text-navy-600">{{ __('Bu etkinlik için kayıtlar kapanmıştır.') }}</p>
                    @endif
                </div>
            </aside>
        </div>

        @include('events.partials.notice')
    </x-container>
</x-layout>
