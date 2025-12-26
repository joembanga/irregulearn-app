<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">🛒 Boutique IrreguLearn
                </h2>
                <p class="text-sm text-gray-700 dark:text-gray-300">Dépense ton XP pour des badges amusants et boosters.
                </p>
            </div>
            <div class="hidden sm:flex items-center gap-3">
                <div class="text-sm text-gray-700 dark:text-gray-300">Ton solde: <span
                        class="font-bold">{{ auth()->user()->xp_total ?? 0 }} XP</span></div>
                <a href="{{ route('shop') }}" class="px-3 py-2 bg-primary text-white rounded-lg">Recharger</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <div class="card-surface rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <livewire:shop-manager />
                </div>
            </div>

            <aside class="space-y-4">
                <div class="card-surface rounded-2xl p-4 shadow-lg border border-gray-100 dark:border-gray-700">
                    <h4 class="font-semibold mb-2 text-gray-900 dark:text-white">Offres du moment</h4>
                    <p class="text-sm text-gray-700 dark:text-gray-300">Boosters x2 XP pour 48h, badges exclusifs, et
                        plus.</p>
                </div>
                <div class="card-surface rounded-2xl p-4 shadow-lg border border-gray-100 dark:border-gray-700">
                    <h4 class="font-semibold mb-2 text-gray-900 dark:text-white">Aide</h4>
                    <p class="text-sm text-gray-700 dark:text-gray-300">Contacte le support pour des remboursements ou
                        questions.</p>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>