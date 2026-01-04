<x-app-layout>
    <div class="py-12 bg-app text-body transition-colors duration-300">
        <div class="max-w-5xl mx-auto px-6">

            <div class="flex flex-row items-center justify-between gap-4 mb-8">
                <div class="flex gap-2 bg-surface p-1 rounded-2xl">
                    <a href="{{ route('leaderboard', ['filter' => 'global', 'period' => $period]) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $filter === 'global' ? 'bg-surface text-primary shadow-sm' : 'text-muted' }}">🌎
                        Global</a>
                    <a href="{{ route('leaderboard', ['filter' => 'friends', 'period' => $period]) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $filter === 'friends' ? 'bg-surface text-primary shadow-sm' : 'text-muted' }}">👥
                        Amis</a>
                </div>

                <div class="flex gap-2 bg-primary/90 p-1 rounded-2xl">
                    <a href="{{ route('leaderboard', ['period' => 'weekly', 'filter' => $filter]) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $period === 'weekly' ? 'bg-primary text-white shadow-sm' : 'text-primary/70 dark:text-primary/70' }}">Cette
                        Semaine</a>
                    <a href="{{ route('leaderboard', ['period' => 'alltime', 'filter' => $filter]) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $period === 'alltime' ? 'bg-primary text-white shadow-sm' : 'text-primary/70 dark:text-primary/70' }}">Tout
                        temps</a>
                </div>
            </div>

            <div
                class="card-surface shadow-xl rounded-2xl overflow-hidden border border-muted transition-colors duration-300">
                <table class="w-full text-left">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="px-6 py-4 text-xs uppercase">Rang</th>
                            <th class="px-6 py-4 text-xs uppercase">Apprenant</th>
                            <th scope="col" class="px-6 py-4 text-xs uppercase text-right">Total XP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-muted">
                        @foreach($users as $index => $u)
                        <tr class="{{ $u->id == auth()->id() ? 'bg-primary/10' : '' }} hover:bg-surface">
                            <td class="px-6 py-5 font-black text-muted">
                                #{{ $users->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-5">
                                <a href="{{ route('profile.public', $u->username) }}"
                                    class="flex items-center gap-3 group">
                                    <div
                                        class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold border-2 border-transparent group-hover:border-primary transition shadow-sm">
                                        {{ substr(\Illuminate\Support\Str::upper($u->username), 0, 1) }}
                                    </div>
                                    <span class="font-bold text-body group-hover:text-primary transition">
                                        {{ $u->username }}
                                    </span>
                                </a>
                            </td>
                            <td class="px-6 py-5 text-right font-mono font-bold text-primary">
                                {{ $period === 'weekly' || $period === null ? number_format($u->xp_weekly) : number_format($u->xp_total) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-6">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>