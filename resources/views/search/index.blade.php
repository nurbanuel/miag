<x-layout title="Arama Sonuçları">
    <x-container class="py-12">
        <h1 class="text-2xl font-bold text-navy-900 sm:text-3xl">{{ __('Arama Sonuçları') }}</h1>
        <p class="mt-2 text-navy-600">
            @if ($query !== '')
                <span class="font-semibold text-navy-900">&ldquo;{{ $query }}&rdquo;</span> {{ __('için') }} {{ $results->count() }} {{ __('sonuç bulundu.') }}
            @else
                {{ __('Aramak istediğiniz kelimeyi yukarıdaki arama kutusuna yazınız.') }}
            @endif
        </p>

        @if ($query !== '' && $results->isEmpty())
            <p class="mt-8 rounded-lg border border-navy-100 bg-navy-50 p-6 text-navy-600">
                {{ __('Sonuç bulunamadı. Farklı bir anahtar kelime deneyebilir ya da') }}
                <a href="{{ lroute('participation.index') }}" class="font-semibold text-turquoise-700 hover:underline">{{ __('katılım') }}</a>
                {{ __('sayfasından bize ulaşabilirsiniz.') }}
            </p>
        @endif

        <ul class="mt-8 flex flex-col gap-4">
            @foreach ($results as $result)
                <li class="rounded-lg border border-navy-100 p-5 hover:border-turquoise-300">
                    <x-badge tone="turquoise" class="mb-2">{{ $result['type'] }}</x-badge>
                    <h2 class="text-lg font-semibold text-navy-900">
                        <a href="{{ $result['href'] }}" class="hover:text-turquoise-700">{{ $result['title'] }}</a>
                    </h2>
                    @if ($result['excerpt'])
                        <p class="mt-1 text-sm text-navy-600">{{ $result['excerpt'] }}</p>
                    @endif
                </li>
            @endforeach
        </ul>
    </x-container>
</x-layout>
