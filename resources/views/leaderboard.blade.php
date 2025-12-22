<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-5xl mx-auto px-6">

            <div class="flex flex-col md:flex-row justify-between gap-4 mb-8">
                <div class="flex gap-2 bg-gray-200 p-1 rounded-2xl">
                    <a href="{{ route('leaderboard', ['filter' => 'global', 'period' => $period]) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $filter === 'global' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500' }}">🌎
                        Global</a>
                    <a href="{{ route('leaderboard', ['filter' => 'classmates', 'period' => $period]) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $filter === 'classmates' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500' }}">👥
                        Amis</a>
                </div>
            
                <div class="flex gap-2 bg-indigo-900 p-1 rounded-2xl">
                    <a href="{{ route('leaderboard', ['period' => 'weekly', 'filter' => $filter]) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $period === 'weekly' ? 'bg-indigo-500 text-white shadow-sm' : 'text-indigo-300' }}">Cette
                        Semaine</a>
                    <a href="{{ route('leaderboard', ['period' => 'alltime', 'filter' => $filter]) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $period === 'alltime' ? 'bg-indigo-500 text-white shadow-sm' : 'text-indigo-300' }}">Tout
                        temps</a>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
                <table class="w-full text-left">
                    <thead class="bg-gray-900 text-white">
                        <tr>
                            <th class="px-6 py-4 text-xs uppercase">Rang</th>
                            <th class="px-6 py-4 text-xs uppercase">Apprenant</th>
                            <th class="px-6 py-4 text-xs uppercase text-right">XP Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $index => $u)
                        <tr class="{{ $u->id == auth()->id() ? 'bg-indigo-50' : '' }}">
                            <td class="px-6 py-5 font-black text-gray-400">
                                #{{ $users->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-5">
                                <a href="{{ route('profile.public', $u->username) }}"
                                    class="flex items-center gap-3 group">
                                    <div
                                        class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border-2 border-transparent group-hover:border-indigo-500 transition shadow-sm">
                                        {{ substr($u->username, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-gray-800 group-hover:text-indigo-600 transition">
                                        {{ $u->username }}
                                    </span>
                                </a>
                            </td>
                            <td class="px-6 py-5 text-right font-mono font-bold text-indigo-600">
                                {{ number_format($u->xp_total) }}
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