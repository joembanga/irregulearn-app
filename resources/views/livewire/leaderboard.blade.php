<div class="bg-white rounded-3xl shadow-xl overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 font-bold text-gray-900">Rang</th>
                <th class="px-6 py-4 font-bold text-gray-900">Utilisateur</th>
                <th class="px-6 py-4 font-bold text-gray-900 text-right">XP Total</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($users as $index => $user)
            <tr class="{{ $user->id == auth()->id() ? 'bg-indigo-50' : '' }}">
                <td class="px-6 py-4 font-black">{{ $users->firstItem() + $index }}</td>
                <td class="px-6 py-4 flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-xs font-bold text-indigo-600">
                        {{ substr($user->username, 0, 1) }}
                    </div>
                    {{ $user->username }}
                </td>
                <td class="px-6 py-4 text-right font-mono font-bold text-indigo-600">
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