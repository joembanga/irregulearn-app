<footer class="relative mt-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto px-6 py-8 flex md:flex-row justify-between items-center gap-4">

        <nav class="flex flex-col md:flex-row gap-3 text-sm text-muted list-none">
            <ul class="flex flex-col md:flex-row gap-3">
                <li>
                    <a href="{{ route('privacy') }}" wire:navigate
                        class="text-muted hover:text-primary transition-colors font-medium">{{ __('Confidentialité') }}</a>
                </li>
                <li>
                    <a href="{{ route('about') }}" wire:navigate
                        class="text-muted hover:text-primary transition-colors font-medium">{{ __('À propos') }}</a>
                </li>
            </ul>
            <div class="hidden md:block">•</div>
            <p class="font-medium">© {{ date('Y') }} IrreguLearn</p>
        </nav>

        @php
            $langs = \App\Models\Lang::all();
        @endphp
        <div x-data="{ showList: false }" class="relative text-sm">
            <button @click="showList = !showList" @click.away="showList = false"
                class="flex items-center gap-2 p-1 hover:cursor-pointer rounded-xl hover:bg-surface transition-colors">
                @foreach ($langs as $lang)
                    @if (app()->getLocale() == $lang->code)
                        <div>{{ $lang->name }}</div>
                    @endif
                    @endforeach
                <svg class="w-4 h-4 text-muted hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="showList" x-transition x-cloak
                class="absolute bottom-full right-0 mb-1 bg-surface border border-muted rounded-sm shadow-xl z-50">
                <ul class="w-full flex flex-col items-center justify-center">
                    @foreach ($langs as $lang)
                        <li class="p-2 {{ app()->getLocale() == $lang->code ? 'hidden' : '' }} font-bold">
                            <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => $lang->code])) }}"
                                wire:navigate
                                class="flex items-center">
                                {{ $lang->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</footer>