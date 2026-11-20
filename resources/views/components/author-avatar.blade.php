@props(['author' => null, 'name' => null, 'size' => 'sm'])

@php
// Yazar fotoğrafı; yoksa ad-soyad baş harfleriyle renkli yuvarlak avatar.
$displayName = $author?->name ?? $name ?? 'MİARGEM';
$sizes = [
    'sm' => 'h-8 w-8 text-[11px]',
    'md' => 'h-10 w-10 text-sm',
    'lg' => 'h-14 w-14 text-lg',
    'xl' => 'h-16 w-16 text-xl',
];
$sizeClass = $sizes[$size] ?? $sizes['sm'];
$palette = ['bg-turquoise-600', 'bg-navy-700', 'bg-[#8b1e3f]', 'bg-navy-500'];
$color = $palette[crc32($displayName) % count($palette)];
@endphp

@if ($author?->avatar_url)
    <img src="{{ $author->avatar_url }}" alt="{{ $displayName }}" loading="lazy" {{ $attributes->merge(['class' => "$sizeClass shrink-0 rounded-full object-cover ring-2 ring-white"]) }} />
@else
    <span aria-hidden="true" {{ $attributes->merge(['class' => "$sizeClass $color inline-flex shrink-0 select-none items-center justify-center rounded-full font-bold tracking-wide text-white ring-2 ring-white"]) }}>
        {{ $author?->initials ?? \App\Models\Author::initialsFor($displayName) }}
    </span>
@endif
