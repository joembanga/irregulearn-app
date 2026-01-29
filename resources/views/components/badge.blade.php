@props(['badge', 'unlocked' => false])

@php
    $colorMap = [
        'orange' => ['text' => 'text-orange-500', 'bg' => 'bg-orange-500/10', 'shadow' => 'shadow-orange-500/20'],
        'slate' => ['text' => 'text-slate-400', 'bg' => 'bg-slate-500/10', 'shadow' => 'shadow-slate-500/20'],
        'yellow' => ['text' => 'text-yellow-500', 'bg' => 'bg-yellow-500/10', 'shadow' => 'shadow-yellow-500/20'],
        'indigo' => ['text' => 'text-indigo-500', 'bg' => 'bg-indigo-500/10', 'shadow' => 'shadow-indigo-500/20'],
        'red' => ['text' => 'text-red-500', 'bg' => 'bg-red-500/10', 'shadow' => 'shadow-red-500/20'],
        'blue' => ['text' => 'text-blue-500', 'bg' => 'bg-blue-500/10', 'shadow' => 'shadow-blue-500/20'],
        'purple' => ['text' => 'text-purple-500', 'bg' => 'bg-purple-500/10', 'shadow' => 'shadow-purple-500/20'],
        'emerald' => ['text' => 'text-emerald-500', 'bg' => 'bg-emerald-500/10', 'shadow' => 'shadow-emerald-500/20'],
        'rose' => ['text' => 'text-rose-500', 'bg' => 'bg-rose-500/10', 'shadow' => 'shadow-rose-500/20'],
        'cyan' => ['text' => 'text-cyan-500', 'bg' => 'bg-cyan-500/10', 'shadow' => 'shadow-cyan-500/20'],
        'pink' => ['text' => 'text-pink-500', 'bg' => 'bg-pink-500/10', 'shadow' => 'shadow-pink-500/20'],
        'amber' => ['text' => 'text-amber-500', 'bg' => 'bg-amber-500/10', 'shadow' => 'shadow-amber-500/20'],
    ];

    $colors = $colorMap[$badge->color] ?? $colorMap['slate'];
@endphp

<div {{ $attributes->merge(['class' => 'relative group flex flex-col items-center p-5 rounded-3xl border border-muted bg-surface shadow-sm hover:shadow-md transition-all duration-300']) }}>
    <div class="size-16 rounded-full flex items-center justify-center mb-4 {{ $colors['bg'] }} {{ $colors['text'] }} {{ $colors['shadow'] }} shadow-inner transition-transform group-hover:scale-110 duration-300">
        <x-dynamic-component :component="'lucide-' . $badge->icon" class="size-8" />
    </div>
    
    <h3 class="font-bold text-sm text-body text-center ">{{ $badge->name }}</h3>
    <p class="text-[10px] font-medium text-muted text-center leading-tight mt-1 px-2 line-clamp-2">{{ $badge->description }}</p>

    @if(!$unlocked)
        <div class="absolute inset-0 bg-surface backdrop-blur-[2px] rounded-xl flex items-center justify-center z-20">
            <x-lucide-lock class="size-5 text-muted/40" />
        </div>
    @endif

    <div class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity z-30">
        @if($unlocked)
            <div class="bg-success text-white text-[8px] font-bold px-2 py-0.5 rounded-full shadow-lg uppercase tracking-widest">
                {{ __('Débloqué') }}
            </div>
        @endif
    </div>
</div>
