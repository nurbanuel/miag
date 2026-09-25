@props(['eyebrow' => null, 'title', 'hint' => null])

<div {{ $attributes->merge(['class' => 'flex flex-wrap items-end justify-between gap-4']) }}>
    <div>
        @if ($eyebrow)
            <p class="mb-1 text-sm font-semibold uppercase tracking-wide text-turquoise-700">{{ $eyebrow }}</p>
        @endif
        <h2 class="text-2xl font-bold text-navy-900 sm:text-3xl">{{ $title }}</h2>
        @if ($hint)
            <p class="mt-2 max-w-2xl text-navy-600">{{ $hint }}</p>
        @endif
    </div>
    @isset($action)
        <div>{{ $action }}</div>
    @endisset
</div>
