<div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="relative mb-8">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input wire:model.live.debounce.300ms="query" type="text"
            class="block w-full pl-10 pr-3 py-4 border border-gray-300 dark:border-gray-700 rounded-2xl leading-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary sm:text-lg transition-colors"
            placeholder="Rechercher un verbe ou un étudiant..." autofocus>
    </div>

    @if(strlen($query) >= 1)
    <div class="space-y-8">

        <div>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-3">
                {{ __('Résultats') }}
            </h3>
            @forelse($verbs as $verb)

            <div wire:click="selectResult('{{ $verb->infinitive }}', '{{ route('verb', $verb->slug) }}')"
                class="cursor-pointer bg-white dark:bg-gray-800 hover:bg-primary/10 dark:hover:bg-gray-700 p-4 rounded-xl shadow-sm mb-2 transition flex items-center justify-between group">

                <div class="flex items-center gap-3">
                    <span class="font-bold text-gray-800 dark:text-gray-200 group-hover:text-primary transition">
                        {{ $verb->infinitive }} --
                    </span>
                    <span class="font-bold text-gray-800 dark:text-gray-200 group-hover:text-primary transition">
                        {{ $verb->past_simple }} --
                    </span>
                    <span class="font-bold text-gray-800 dark:text-gray-200 group-hover:text-primary transition">
                        {{ $verb->past_participle }} --
                    </span>
                </div>

            </div>

            @empty
            @endforelse

            @forelse($users as $user)
            <div wire:click="selectResult('{{ $user->username }}', '{{ route('profile.public', $user->username) }}')"
                class="cursor-pointer bg-white dark:bg-gray-800 hover:bg-primary/10 dark:hover:bg-gray-700 p-4 rounded-xl shadow-sm mb-2 transition flex items-center justify-between group">

                <div class="flex items-center gap-3">
                    <div
                        class="h-10 w-10 rounded-full bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-primary dark:text-primary/80 font-bold">
                        {{ substr(\Illuminate\Support\Str::upper($user->username), 0, 1) }}
                    </div>
                    <span class="font-bold text-gray-800 dark:text-gray-200 group-hover:text-primary transition">
                        {{ $user->username }}
                    </span>
                </div>

            </div>
            @empty
            @endforelse
        </div>
    </div>
    @elseif(count($history) > 0)
    <div class="mt-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recherches récentes</h3>
            <button wire:click="clearHistory" class="text-sm text-red-500 hover:text-red-700 dark:hover:text-red-400">
                Effacer l'historique
            </button>
        </div>

        <div class="flex flex-col space-y-2">
            @foreach($history as $term)
            <button wire:click="searchFromHistory('{{ $term }}')"
                class="w-full text-left flex items-center px-4 py-3 bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl transition group">
                <span class="mr-3 text-gray-600 group-hover:text-primary/80 transition">🕒</span>
                <span class="font-medium">{{ $term }}</span>
                <svg class="w-4 h-4 ml-auto text-gray-600 group-hover:text-primary/70 opacity-0 group-hover:opacity-100 transition"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            @endforeach
        </div>
    </div>
    @else
    <div class="text-center py-20">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary/10 dark:bg-gray-800 mb-4">
            <svg class="w-8 h-8 text-primary/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Commencez à explorer</h3>
        <p class="mt-1 text-gray-600 dark:text-gray-300">Recherchez des verbes irréguliers ou vos camarades.</p>
    </div>
    @endif
</div>