<div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700">
            <tr>
                <th class="px-6 py-4 font-bold text-gray-900 dark:text-white">Rang</th>
                <th class="px-6 py-4 font-bold text-gray-900 dark:text-white">Utilisateur</th>
                <th class="px-6 py-4 font-bold text-gray-900 dark:text-white text-right">XP Total</th>
            </tr>
        </thead>
        <tbody class="divide-y dark:divide-gray-700">
            @foreach($users as $index => $user)
            <tr class="{{ $user->id == auth()->id() ? 'bg-primary/10 dark:bg-primary/20' : '' }}">
                <td class="px-6 py-4 font-black">{{ $users->firstItem() + $index }}</td>
                <td class="px-6 py-4 flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center text-xs font-bold text-primary">
                        {{ substr($user->username, 0, 1) }}
                    </div>
                    {{ $user->username }}
                </td>
                <td class="px-6 py-4 text-right font-mono font-bold text-primary">
                    {{ number_format($user->xp_total) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-6 border-t">
        {{ $users->links() }}
    </div>
</div>