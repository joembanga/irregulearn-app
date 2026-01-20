<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Discovery Card -->
    <div class="card-surface p-6 rounded-xl border border-muted relative overflow-hidden flex flex-col justify-between min-h-70 group">
        <div class="relative z-10">
            <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-200/20 text-primary text-[10px] font-bold uppercase tracking-wider mb-4">
                Nouveautés
            </div>
            <h3 class="text-2xl font-bold text-body mb-3 tracking-tight">Explore l'écosystème</h3>
            <p class="text-muted text-sm max-w-sm leading-relaxed mb-6">
                Débloque de nouveaux thèmes dans la boutique ou recherche des verbes spécifiques pour approfondir tes
                connaissances.
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="{{ route('shop') }}" wire:navigate class="flex items-center gap-2 px-5 py-3 bg-primary text-surface rounded-xl font-bold text-sm hover:scale-105 transition shadow-sm active:scale-95 group-hover:shadow-indigo-500/20">
                    <x-heroicon-o-shopping-cart class="size-5 inline rotate-y-180" /> La Boutique
                </a>
                <a href="{{ route('search') }}" wire:navigate class="flex items-center gap-2 px-5 py-3 bg-surface border border-muted text-body rounded-xl font-bold text-sm hover:bg-muted/10 transition active:scale-95">
                    <x-lucide-search class="size-5 inline" /> Rechercher
                </a>
            </div>
        </div>
        <div class="absolute -right-6 -bottom-6 opacity-5 rotate-3 pointer-events-none group-hover:rotate-0 transition-transform duration-700">
            <x-lucide-sparkles class="size-30 stroke-1" />
        </div>
    </div>

    <!-- Friends Section -->
    <div class="card-surface p-6 rounded-xl border border-muted flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold text-body flex items-center gap-2 tracking-tighter">
                    <x-lucide-users-round class="size-7 text-primary" /> Mes Grambuds
                </h3>
                <a href="{{ route('grambuds') }}" wire:navigate class="text-[10px] font-bold text-primary uppercase tracking-widest hover:underline">
                    Voir tout <x-lucide-move-right class="size-3 inline stroke-3" />
                </a>
            </div>

            @php $friends = auth()->user()->friends(10)->get(); @endphp
            <div class="flex flex-wrap gap-4">
                @forelse($friends as $friend)
                <a href="{{ route('profile.public', $friend->username) }}" wire:navigate class="group flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary font-black truncate">
                        <x-user-avatar :user="$friend"/>
                    </div>
                    <span class="text-[9px] font-bold text-muted group-hover:text-primary transition-colors lowercase tracking-tight">{{ $friend->username }}</span>
                </a>
                @empty
                <div class="flex flex-col items-center justify-center w-full py-4 text-center">
                    <p class="text-xs text-muted font-medium mb-4 italic">Seul on va vite, ensemble on va loin.</p>
                    <a href="{{ route('leaderboard') }}" wire:navigate
                        class="px-4 py-2 border border-muted rounded-xl text-[10px] font-bold text-muted hover:bg-muted/10 transition uppercase tracking-widest">Trouver
                        des amis
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-muted/50 flex items-center justify-between">
            <div class="text-[10px] text-muted font-bold uppercase tracking-widest">Public Profile</div>
            <a href="{{ route('profile.public', auth()->user()->username) }}" wire:navigate
                class="text-[10px] font-bold text-primary hover:text-primary/80 transition-colors uppercase tracking-widest">
                VOIR MON PROFIL <x-lucide-move-right class="size-3 inline stroke-3" />
            </a>
        </div>
    </div>
</div>