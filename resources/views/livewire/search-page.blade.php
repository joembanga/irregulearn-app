<div class="w-full">
    <!-- Search Bar -->
    <div class="relative mb-12 group">
        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
            <svg class="h-6 w-6 text-muted group-focus-within:text-primary transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input wire:model.live.debounce.200ms="query" type="text"
            class="block w-full pl-16 pr-6 py-6 bg-surface border-4 border-muted/30 rounded-xl text-xl font-bold placeholder:text-muted/40 text-body focus:outline-none focus:border-primary focus:ring-8 focus:ring-primary/5 transition-all duration-300 shadow-xl shadow-muted/5 group-hover:border-muted/50"
            placeholder="Rechercher un verbe, un utilisateur..." autofocus>
        
        <div wire:loading wire:target="query" class="absolute inset-y-0 right-6 flex items-center">
            <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    @if(strlen($query) >= 1)
    <div class="space-y-12 animate-fade-in">
        <!-- Verb Results -->
        @if($verbs->count() > 0)
        <div>
            <h3 class="text-[10px] font-bold text-muted uppercase  mb-6 flex items-center gap-3">
                <x-lucide-book-open class="size-4" /> Verbes irréguliers
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($verbs as $verb)
                <div wire:click="selectResult('{{ $verb->infinitive }}', '{{ route('verbs.show', $verb->slug) }}')"
                    class="group cursor-pointer p-6 bg-surface rounded-xl border-2 border-muted/50 hover:border-primary transition-all duration-300 hover:shadow-2xl hover:shadow-primary/5 active:scale-95 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                            EN
                        </div>
                        <div>
                            <span class="text-lg font-bold text-body group-hover:text-primary transition-colors  uppercase">
                                {{ $verb->infinitive }}
                            </span>
                            @php $verbTranslation = $verb->translations()->where('lang_code', app()->getLocale())->first(); @endphp
                            <div class="text-[10px] font-bold text-muted uppercase er mt-1">
                                {{ app()->getLocale() !== "en" ? Str::limit($verbTranslation->translation, 20) : '' }}
                            </div>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-muted group-hover:text-primary transition-all duration-300 transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- User Results -->
        @if($users->count() > 0)
        <div>
            <h3 class="text-[10px] font-bold text-muted uppercase  mb-6 flex items-center gap-3">
                <x-lucide-users-2 class="size-4" /> Étudiants
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($users as $user)
                <div wire:click="selectResult('{{ $user->username }}', '{{ route('profile.public', $user->username) }}')"
                    class="group cursor-pointer p-6 bg-surface rounded-3xl border-2 border-muted/50 hover:border-primary transition-all duration-300 hover:shadow-2xl hover:shadow-primary/5 active:scale-95 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-muted font-black truncate">
                            <x-user-avatar :user="$user"/>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-body group-hover:text-primary transition-colors ">
                                {{ $user->username }}
                            </div>
                            <div class="text-[10px] font-bold text-muted uppercase tracking-widest mt-0.5">
                                {{ $user->xp_total }} XP • Niv. {{ ceil($user->xp_total / 1000) ?: 1 }}
                            </div>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-muted group-hover:text-primary transition-all duration-300 transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($verbs->count() === 0 && $users->count() === 0)
        <div class="text-center py-20 bg-muted/5 rounded-2xl border-4 border-dashed border-muted/20">
            <x-lucide-search class="size-16 mb-6 mx-auto text-muted/50" />
            <h3 class="text-xl font-bold text-body uppercase mb-2">Aucun résultat</h3>
            <p class="text-muted font-medium">Nous n'avons rien trouvé pour "{{ $query }}".</p>
        </div>
        @endif
    </div>

    @elseif(count($history) > 0 && auth()->check())
    <div class="mt-8 animate-fade-in-up">
        <div class="flex items-center justify-between mb-8 px-2">
            <h3 class="text-[10px] font-bold text-muted uppercase ">Historique récent</h3>
            <button wire:click="clearHistory"
                class="text-[10px] font-bold text-danger uppercase  hover:opacity-70 transition-opacity">
                Effacer tout
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($history as $term)
            <button wire:click="searchFromHistory('{{ $term }}')"
                class="group w-full text-left flex items-center px-6 py-4 bg-muted/5 hover:bg-surface border-2 border-transparent hover:border-primary/20 text-muted rounded-2xl transition-all duration-300 group">
                <span class="mr-4 text-muted group-hover:text-primary transition-colors">
                    <x-lucide-clock-3 class="size-4 inline" />
                </span>
                <span class="font-bold text-body  group-hover:text-primary transition-colors">{{ $term }}</span>
                <svg class="w-4 h-4 ml-auto text-muted group-hover:text-primary/70 opacity-0 group-hover:opacity-100 transition-all duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            @endforeach
        </div>
    </div>
    @else
    <div class="text-center py-24 bg-surface rounded-2xl border border-muted shadow-2xl relative overflow-hidden group">
        <div class="absolute inset-0 bg-linear-to-br from-primary/5 to-transparent pointer-events-none"></div>
        <div class="relative z-10 flex flex-col items-center">
            <div class="w-24 h-24 rounded-2xl bg-primary/10 flex items-center justify-center mb-8 rotate-3 transition-transform group-hover:rotate-0 duration-500">
                <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-body  uppercase mb-2">Commence ton exploration</h3>
            <p class="text-muted max-w-xs mx-auto font-medium leading-relaxed">
                Apprends de nouveaux verbes ou défie tes amis en recherchant leur profil.
            </p>
        </div>
    </div>
    @endif
</div>