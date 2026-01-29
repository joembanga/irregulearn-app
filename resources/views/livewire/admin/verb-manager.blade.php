<div>
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Verbs Library</h2>
        <a href="{{ route('admin.verbs.create') }}" wire.navigate
            class="w-full sm:w-auto px-4 py-2 bg-primary text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Verb
        </a>
    </div>

    <!-- Search Tool -->
    <div class="mb-6">
        <div class="relative">
            <input wire:model.live.debounce.200ms="search" type="text" placeholder="Search verbs..."
                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Verbs Table -->
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-soft border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr
                        class="bg-gray-50 dark:bg-gray-700 text-xs uppercase tracking-wider text-gray-500 font-semibold border-b border-gray-100 dark:border-gray-600">
                        <th class="px-6 py-4">Infinitive</th>
                        <th class="px-6 py-4">Past Simple</th>
                        <th class="px-6 py-4">Past Participle</th>
                        <th class="px-6 py-4">Translation</th>
                        <th class="px-6 py-4">Level</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($verbs as $verb)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $verb->infinitive }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $verb->past_simple }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $verb->past_participle }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $verb->translation }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 text-xs rounded-full {{ $verb->level === 'beginner' ? 'bg-green-100 text-green-700' : ($verb->level === 'intermediate' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($verb->level) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.verbs.edit', $verb) }}" wire.navigate
                                class="text-blue-500 hover:text-blue-700 text-sm font-medium">Edit</a>
                            <button wire:click="confirmVerbDeletion({{ $verb->id }})"
                                class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-6 lg:py-12 text-center text-gray-500">
                            No verbs found matching your search.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $verbs->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal (Native HTML/Alpine or simpler logic) -->
    @if ($confirmingVerbDeletion)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-2xl max-w-sm w-full mx-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">Delete Verb?</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Are you sure you want to delete this verb? This action
                cannot be undone.</p>
            <div class="flex justify-end gap-3">
                <button wire:click="$set('confirmingVerbDeletion', false)"
                    class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                <button wire:click="deleteVerb"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
