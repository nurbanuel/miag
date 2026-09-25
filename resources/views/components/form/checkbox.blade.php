@props(['name', 'required' => false])

<div>
    <label for="{{ $name }}" class="flex items-start gap-2.5 text-sm text-navy-700">
        <input
            type="checkbox"
            id="{{ $name }}"
            name="{{ $name }}"
            value="1"
            @if($required) required @endif
            class="mt-0.5 h-4 w-4 rounded border-navy-300 text-turquoise-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-turquoise-500"
        />
        <span>{{ $slot }}</span>
    </label>
    @error($name)
        <p class="mt-1.5 text-sm text-bordo-600">{{ $message }}</p>
    @enderror
</div>
