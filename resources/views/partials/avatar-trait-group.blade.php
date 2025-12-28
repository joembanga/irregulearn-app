<div>
    <h4
        class="text-[10px] font-black uppercase text-gray-400 dark:text-gray-500 mb-4 tracking-widest flex items-center">
        {{ preg_replace('/(?<!^)[A-Z]/', ' $0', $trait) }}
        <div class="ml-2 flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
    </h4>
    <div class="flex flex-wrap gap-2">
        @foreach($options[$trait] as $value)
        @php
        $isLocked = isset($premiumOptions[$trait]) && in_array($value, $premiumOptions[$trait]) && auth()->user()->xp_balance < 500;
            $isActive = ($settings[$trait] ?? '' ) === $value; @endphp
            <button wire:click="updateProperty('{{ $trait }}', '{{ $value }}')" class="px-3 py-1.5 rounded-xl text-[11px] font-bold transition-all border-2 
                {{ $isActive ? 'border-indigo-600 bg-indigo-600 text-white shadow-md' : 'border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:border-indigo-300' }}
                {{ $isLocked ? 'opacity-40 cursor-not-allowed' : '' }}">
            {{ $value }} @if($isLocked) 🔒 @endif
            </button>
            @endforeach
    </div>
</div>