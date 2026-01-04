@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-muted focus:border-primary focus:ring-primary rounded-md shadow-sm dark:bg-gray-900/50 text-body']) }}>