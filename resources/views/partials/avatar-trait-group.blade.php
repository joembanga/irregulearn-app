<div>
    <h4 class="text-[10px] font-black uppercase text-muted mb-4 tracking-widest flex items-center">
        {{ preg_replace('/(?<!^)[A-Z]/', ' $0', $trait) }}
        <div class="ml-2 flex-1 h-px bg-surface dark:bg-gray-700"></div>
    </h4>
    <div class="flex flex-wrap gap-2">
        @foreach($options[$trait] as $value)
        @php
        $isLocked = isset($premiumOptions[$trait]) && in_array($value, $premiumOptions[$trait]) && auth()->user()->xp_balance < 500;
            $isActive=($settings[$trait] ?? '' )===$value;
            @endphp
            <button
            wire:key="opt-{{ $trait }}-{{ $value }}"
            wire:click.prevent="updateProperty('{{ $trait }}', '{{ $value }}')"
            type="button"
            class="px-3 py-1.5 rounded-xl text-[11px] font-bold transition-all border-2 
                {{ $isActive ? 'border-primary bg-primary text-surface shadow-md' : 'border-muted bg-surface text-muted hover:border-primary' }}
                {{ $isLocked ? 'opacity-40 cursor-not-allowed' : '' }}">
            {{ $value }} @if($isLocked) 🔒 @endif
            </button>
            @endforeach
    </div>
</div>