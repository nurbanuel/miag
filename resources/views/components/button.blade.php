@props(['href' => null, 'variant' => 'primary', 'size' => 'md', 'type' => 'button'])

@php
$variants = [
    'primary' => 'bg-bordo-600 text-white hover:bg-bordo-700',
    'navy' => 'bg-navy-900 text-white hover:bg-navy-800',
    'turquoise' => 'bg-turquoise-600 text-white hover:bg-turquoise-700',
    'outline' => 'border border-navy-200 text-navy-900 hover:bg-navy-50 bg-white',
    'outline-light' => 'border border-white/30 text-white hover:bg-white/10 bg-transparent',
    'ghost' => 'text-navy-900 hover:bg-navy-50',
];
$sizes = [
    'sm' => 'px-3 py-1.5 text-sm',
    'md' => 'px-5 py-2.5 text-sm',
    'lg' => 'px-6 py-3 text-base',
];
$classes = 'inline-flex items-center justify-center gap-2 rounded-md font-medium transition-colors disabled:opacity-50 disabled:pointer-events-none '
    . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
