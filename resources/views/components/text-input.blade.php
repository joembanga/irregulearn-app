@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'px-4 py-3 bg-surface border-muted focus:border-primary focus:ring-primary rounded-2xl shadow-sm text-body placeholder:text-muted/50 transition-all duration-200']) }}>