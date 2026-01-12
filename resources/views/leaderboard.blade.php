<x-app-layout>
    <div class="py-12 px-8 bg-app text-body transition-colors duration-300">
        <div class="max-w-5xl mx-auto px-6">

            <!-- Podium for Top 3 (Desktop) -->
            <div class="hidden md:flex items-end justify-center gap-4 pt-10 pb-4">

                @if($top3->count() >= 2)
                <!-- 2nd Place -->
                <div class="flex flex-col items-center gap-4 group">
                    <div class="relative">
                        <div
                            class="w-24 h-24 rounded-3xl bg-surface border-4 border-slate-300 flex items-center justify-center text-3xl font-black text-slate-400 shadow-lg group-hover:scale-110 transition-transform">
                            {{ substr($top3[1]->username, 0, 1) }}
                        </div>
                        <div
                            class="absolute -bottom-3 -right-3 w-10 h-10 bg-slate-300 rounded-xl flex items-center justify-center text-white font-black text-sm">
                            2</div>
                    </div>
                    <div class="text-center">
                        <p class="font-black text-body">{{ $top3[1]->username }}</p>
                        <p class="text-xs font-bold text-primary">
                            {{ $period === 'weekly' || $period === null ? number_format($top3[1]->xp_weekly) : number_format($top3[1]->xp_total) }}
                            XP
                        </p>
                    </div>
                </div>
                @endif

                @if($top3->count() >= 1)
                <!-- 1st Place -->
                <div class="flex flex-col items-center gap-4 group -mt-10">
                    <div class="relative">
                        <div
                            class="w-32 h-32 rounded-[2.5rem] bg-surface border-4 border-warning flex items-center justify-center text-5xl font-black text-warning shadow-2xl group-hover:scale-110 transition-transform">
                            {{ substr($top3[0]->username, 0, 1) }}
                        </div>
                        <div class="absolute -top-6 left-1/2 -translate-x-1/2 text-4xl animate-bounce">👑</div>
                        <div
                            class="absolute -bottom-3 -right-3 w-12 h-12 bg-warning rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg">
                            1</div>
                    </div>
                    <div class="text-center">
                        <p class="text-xl font-black text-body">{{ $top3[0]->username }}</p>
                        <p class="text-sm font-bold text-primary">
                            {{ $period === 'weekly' || $period === null ? number_format($top3[0]->xp_weekly) : number_format($top3[0]->xp_total) }}
                            XP
                        </p>
                    </div>
                </div>
                @endif

                @if($top3->count() >= 3)
                <!-- 3rd Place -->
                <div class="flex flex-col items-center gap-4 group">
                    <div class="relative">
                        <div
                            class="w-24 h-24 rounded-3xl bg-surface border-4 border-orange-400 flex items-center justify-center text-3xl font-black text-orange-400 shadow-lg group-hover:scale-110 transition-transform">
                            {{ substr($top3[2]->username, 0, 1) }}
                        </div>
                        <div
                            class="absolute -bottom-3 -right-3 w-10 h-10 bg-orange-400 rounded-xl flex items-center justify-center text-white font-black text-sm">
                            3</div>
                    </div>
                    <div class="text-center">
                        <p class="font-black text-body">{{ $top3[2]->username }}</p>
                        <p class="text-xs font-bold text-primary">
                            {{ $period === 'weekly' || $period === null ? number_format($top3[2]->xp_weekly) : number_format($top3[2]->xp_total) }}
                            XP
                        </p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Mobile Header (Rich Greeting) -->
            <div class="md:hidden text-center space-y-2 mb-8">
                <h3 class="text-3xl font-black text-body uppercase tracking-tighter">Le Classement</h3>
                <p class="text-sm text-muted font-medium italic">Seul on va vite, ensemble on va loin.</p>
            </div>

            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
                <div class="flex gap-2 bg-surface p-1 rounded-2xl">
                    <a href="{{ route('leaderboard', ['filter' => 'global', 'period' => $period]) }}" wire:navigate
                        class="w-full md:w-auto px-4 py-2 rounded-xl text-center text-sm font-bold {{ $filter === 'global' ? 'bg-primary/50 text-body shadow-sm' : 'text-muted' }} transition transition-color">
                        🌎 Global
                    </a>
                    <a href="{{ route('leaderboard', ['filter' => 'friends', 'period' => $period]) }}" wire:navigate
                        class="w-full md:w-auto px-4 py-2 rounded-xl text-center text-sm font-bold {{ $filter === 'friends' ? 'bg-primary/50 text-body shadow-sm' : 'text-muted' }} transition transition-color">
                        👥 Amis
                    </a>
                </div>

                <div class="flex gap-2 bg-primary/60 p-1 rounded-2xl">
                    <a href="{{ route('leaderboard', ['period' => 'weekly', 'filter' => $filter]) }}" wire:navigate
                        class="w-full md:w-auto px-4 py-2 rounded-xl text-sm text-center font-bold {{ $period === 'weekly' ? 'bg-primary text-white shadow-sm' : 'text-muted' }}">
                        Cette Semaine
                    </a>
                    <a href="{{ route('leaderboard', ['period' => 'alltime', 'filter' => $filter]) }}" wire:navigate
                        class="w-full md:w-auto px-4 py-2 rounded-xl text-sm text-center font-bold {{ $period === 'alltime' ? 'bg-primary text-white shadow-sm' : 'text-muted' }}">
                        Tout temps
                    </a>
                </div>
            </div>
            <!-- Table/Card List -->
            <div class="card-surface rounded-[2.5rem] shadow-2xl border border-muted overflow-hidden">
                <!-- Mobile: card list to avoid overflow -->
                <div class="md:hidden p-3 space-y-3">
                    @foreach($users as $index => $user)
                    @php $rank = $users->firstItem() + $index; @endphp
                    <a href="{{ route('profile.public', $user->username) }}" wire:navigate
                        class="block p-2 rounded-xl bg-surface/40 hover:bg-surface/60 transition">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary font-black truncate">
                                    {{ substr($user->username,0,1) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-black text-body truncate">{{ $user->username }}</div>
                                    <div class="text-[11px] text-muted truncate">{{ $user->current_streak }} jours de
                                        série •
                                        {{ $period === 'weekly' || $period === null ? number_format($user->xp_weekly) : number_format($user->xp_total) }}
                                        XP
                                    </div>
                                </div>
                            </div>
                            <div class="text-left">
                                <div class="font-bold text-primary">@if($rank==1) 🥇 @elseif($rank==2) 🥈
                                    @elseif($rank==3) 🥉 @else #{{ $rank }} @endif</div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-primary/5 border-b border-muted">
                            <tr>
                                <th class="px-8 py-6 text-[10px] font-black text-muted uppercase tracking-[0.2em]">Rang
                                </th>
                                <th class="px-8 py-6 text-[10px] font-black text-muted uppercase tracking-[0.2em]">
                                    Utilisateur
                                </th>
                                <th
                                    class="px-8 py-6 text-[10px] font-black text-muted uppercase tracking-[0.2em] text-right">
                                    {{ $period === 'weekly' || $period === null ? 'XP GAGNE' : 'XP TOTAL' }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-muted/30">
                            @foreach($users as $index => $user)
                            @php $rank = $users->firstItem() + $index; @endphp
                            <tr
                                class="group hover:bg-primary/5 transition-colors {{ $user->id == auth()->id() ? 'bg-primary/10' : '' }}">
                                <td class="px-8 py-6">
                                    @if($rank == 1) <span class="text-2xl">🥇</span>
                                    @elseif($rank == 2) <span class="text-2xl">🥈</span>
                                    @elseif($rank == 3) <span class="text-2xl">🥉</span>
                                    @else <span class="text-lg font-black text-muted">#{{ $rank }}</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <a href="{{ route('profile.public', $user->username) }}" wire:navigate
                                        class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary font-black shadow-inner group-hover:scale-110 transition-transform">
                                            {{ substr($user->username, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-black text-body group-hover:text-primary transition-colors">
                                                {{ $user->username }}
                                            </p>
                                            <p class="text-[10px] font-bold text-muted uppercase tracking-widest">
                                                {{ $user->current_streak }} jours de série 🔥
                                            </p>
                                        </div>
                                    </a>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="text-xl font-black text-primary tracking-tight">
                                        {{ $period === 'weekly' || $period === null ? number_format($user->xp_weekly) : number_format($user->xp_total) }}
                                    </span>
                                    <span class="text-xs font-bold text-muted uppercase ml-1">XP</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-8 border-t border-muted bg-surface/50">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>