<x-app-layout>
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="font-semibold text-xl text-body leading-tight">
            🛒 Boutique IrreguLearn
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <div class="card-surface rounded-2xl p-6 shadow-lg border border-muted">
                    <livewire:shop-manager />
                </div>
            </div>

            <aside class="space-y-4">
                <div class="card-surface rounded-2xl p-4 shadow-lg border border-muted">
                    <h4 class="font-semibold mb-2 text-body">Offres du moment</h4>
                    <p class="text-sm text-muted">Boosters x2 XP pour 48h, badges exclusifs, et
                        plus.</p>
                </div>
                <div class="card-surface rounded-2xl p-4 shadow-lg border border-muted">
                    <h4 class="font-semibold mb-2 text-body">Aide</h4>
                    <p class="text-sm text-muted">Contacte le support pour des remboursements ou
                        questions.</p>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>