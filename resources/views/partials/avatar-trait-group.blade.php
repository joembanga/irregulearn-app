@php
    // Dependency Logic
    $show = true;
    if (isset($dependencies[$trait])) {
        foreach ($dependencies[$trait] as $dependentKey => $validValues) {
            if (!in_array($settings[$dependentKey] ?? '', $validValues)) {
                $show = false;
                break;
            }
        }
    }
@endphp

@if($show)
<div>
    <h4 class="text-[10px] font-black uppercase text-muted mb-4 tracking-widest flex items-center">
        {{ preg_replace('/(?<!^)[A-Z]/', ' $0', $trait) }}
        <div class="ml-2 flex-1 h-px bg-surface dark:bg-gray-700"></div>
    </h4>
    <div class="flex flex-wrap gap-2">
        @foreach($options[$trait] as $value)
        @php
            $isPremium = isset($premiumOptions[$trait]) && in_array($value, $premiumOptions[$trait]);
            $isUnlocked = $isPremium ? in_array($value, auth()->user()->unlocked_items ?? []) : true;
            $isActive=($settings[$trait] ?? '' ) === $value;
        @endphp

        <button
            wire:key="opt-{{ $trait }}-{{ $value }}"
            wire:click.prevent="updateProperty('{{ $trait }}', '{{ $value }}')"
            type="button"
            class="px-3 py-1.5 rounded-xl text-[11px] font-bold transition-all border-2
                {{ $isActive ? 'border-primary bg-primary text-surface shadow-md' : 'border-muted bg-surface text-muted hover:border-primary' }}
                {{ $isPremium && !$isUnlocked ? 'ring-1 ring-red-400' : '' }}"
        >
            {{ $value }}
            @if($isPremium && !$isUnlocked) 
                <span class="ml-1 text-red-500">🔒</span>
            @endif
        </button>
        @endforeach
    </div>
</div>
@endif
