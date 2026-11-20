@props(['name', 'label', 'type' => 'text', 'required' => false, 'hint' => null, 'value' => null])

<div>
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-navy-800">
        {{ $label }} @if($required)<span class="text-bordo-600">*</span>@endif
    </label>
    @if ($hint)
        <p class="mb-1.5 text-xs text-navy-500">{{ $hint }}</p>
    @endif
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-md border px-3.5 py-2.5 text-sm text-navy-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-turquoise-500 ' . ($errors->has($name) ? 'border-bordo-400' : 'border-navy-200')]) }}
    />
    @error($name)
        <p class="mt-1.5 text-sm text-bordo-600">{{ $message }}</p>
    @enderror
</div>
