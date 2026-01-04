<div>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Users Directory</h2>
            <p class="text-sm text-gray-500">Manage your application users.</p>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-6 max-w-md">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by username or email..." class="w-full px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-soft border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700 text-xs uppercase tracking-wider text-gray-500 font-semibold border-b border-gray-100 dark:border-gray-600">
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Joined</th>
                        <th class="px-6 py-4">Role</th>
                        {{-- <th class="px-6 py-4 text-right">Actions</th> --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-xs font-bold text-gray-500 dark:text-gray-300">
                                    {{ substr($user->username, 0, 2) }}
                                </div>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $user->username }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($user->role ?? 'User') }}
                            </span>
                        </td>
                        {{-- <td class="px-6 py-4 text-right">
                            <button class="text-gray-400 hover:text-gray-600">...</button>
                        </td> --}}
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $users->links() }}
        </div>
    </div>
</div>