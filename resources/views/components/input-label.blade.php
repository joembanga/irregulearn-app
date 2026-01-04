@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-body']) }}>
    {{ $value ?? $slot }}
</label>
