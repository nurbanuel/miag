@props(['class' => ''])

<div {{ $attributes->merge(['class' => "rounded-xl border border-navy-100 bg-white shadow-sm transition-shadow hover:shadow-md $class"]) }}>
    {{ $slot }}
</div>
