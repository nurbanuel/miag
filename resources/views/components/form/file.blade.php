@props(['name', 'label', 'required' => false, 'hint' => 'PDF veya DOCX, en fazla 10MB'])

<div>
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-navy-800">
        {{ $label }} @if($required)<span class="text-bordo-600">*</span>@endif
    </label>
    @if ($hint)
        <p class="mb-1.5 text-xs text-navy-500">{{ $hint }}</p>
    @endif
    <input
        type="file"
        id="{{ $name }}"
        name="{{ $name }}"
        accept=".pdf,.docx"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-md border px-3.5 py-2.5 text-sm text-navy-900 file:mr-3 file:rounded file:border-0 file:bg-navy-100 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-navy-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-turquoise-500 ' . ($errors->has($name) ? 'border-bordo-400' : 'border-navy-200')]) }}
    />
    @error($name)
        <p class="mt-1.5 text-sm text-bordo-600">{{ $message }}</p>
    @enderror
</div>
