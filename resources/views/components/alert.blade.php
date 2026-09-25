@props(['tone' => 'success'])

@php
$tones = [
    'success' => 'bg-turquoise-50 text-turquoise-900 border-turquoise-200',
    'error' => 'bg-bordo-50 text-bordo-900 border-bordo-200',
];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-start gap-2 rounded-lg border p-4 text-sm ' . ($tones[$tone] ?? $tones['success'])]) }} role="alert">
    {{ $slot }}
</div>
