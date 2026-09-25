@props(['tone' => 'navy'])

@php
$tones = [
    'navy' => 'bg-navy-100 text-navy-800',
    'turquoise' => 'bg-turquoise-100 text-turquoise-900',
    'bordo' => 'bg-bordo-100 text-bordo-800',
];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide ' . ($tones[$tone] ?? $tones['navy'])]) }}>
    {{ $slot }}
</span>
