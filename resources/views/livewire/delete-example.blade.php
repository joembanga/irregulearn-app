<div>
    <!-- Delete Button -->
    <button 
        wire:click="confirmDelete"
        class="inline-flex items-center gap-2 px-4 py-2 bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 rounded-lg font-semibold text-sm hover:bg-red-500/20 transition active:scale-95 shadow-sm"
        title="{{ __('Delete this example') }}"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
        <span>{{ __('Delete') }}</span>
    </button>

    <!-- Confirmation Modal -->
    @if($showConfirmation)
    <div 
        x-data="{ show: @entangle('showConfirmation') }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        style="display: none;"
    >
        <div 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="card-surface rounded-2xl p-8 max-w-md w-full shadow-2xl border border-surface"
            @click.away="$wire.cancelDelete()"
        >
            <!-- Icon -->
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-red-500/10 rounded-full">
                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <!-- Title -->
            <h3 class="text-2xl font-bold text-body text-center mb-3">
                {{ __('Delete Example?') }}
            </h3>

            <!-- Message -->
            <p class="text-muted text-center mb-8">
                {{ __('This action cannot be undone. Your example will be permanently deleted.') }}
            </p>

            <!-- Actions -->
            <div class="flex gap-4">
                <button 
                    wire:click="cancelDelete"
                    class="flex-1 px-6 py-3 bg-surface text-body rounded-xl font-semibold hover:bg-surface/80 transition"
                >
                    {{ __('Cancel') }}
                </button>
                <button 
                    wire:click="delete"
                    class="flex-1 px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition active:scale-95"
                >
                    {{ __('Delete') }}
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
