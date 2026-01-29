<div x-data="{ showList: false }" @click.away="showList = false" class="relative text-sm">
    <button type="button" @click="showList = !showList"
        class="flex items-center gap-2 px-4 py-2 hover:cursor-pointer rounded-xl hover:bg-primary/5 transition-all border border-primary/10 font-bold text-body">
        @foreach ($langs as $lang)
        @if (app()->getLocale() == $lang->code)
        <span class="uppercase">{{ $lang->code }}</span>
        @endif
        @endforeach
        <x-lucide-chevron-down class="size-4 text-primary transition-transform duration-300 stroke-current fill-none" ::class="showList ? 'rotate-180' : ''" />
    </button>

    <div x-show="showList" x-transition x-cloak class="absolute bottom-full right-0 mb-1 bg-surface border border-primary/10 rounded-xl shadow-xl z-50 min-w-30 overflow-hidden w-auto">
        <ul class="w-full flex flex-col">
            @foreach ($langs as $lang)
            <li class="{{ app()->getLocale() == $lang->code ? 'bg-primary/5 text-primary' : 'hover:bg-primary/5' }} transition-colors">
                @php
                    $segments = request()->segments();
                    if (isset($segments[0]) && in_array($segments[0], ['en', 'fr'])) {
                        $segments[0] = $lang->code;
                    } else {
                        array_unshift($segments, $lang->code);
                    }
                    $newPath = implode('/', $segments);
                    $newUrl = url($newPath) . (request()->getQueryString() ? '?' . request()->getQueryString() : '');
                @endphp
                <a href="{{ $newUrl }}" wire:navigate class="flex items-center px-4 py-3 font-bold text-sm">
                    {{ $lang->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>