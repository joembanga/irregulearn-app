@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'w-full px-4 py-3 bg-surface border border-muted rounded-xl text-body placeholder:text-muted/50 transition-all duration-200']) }}>