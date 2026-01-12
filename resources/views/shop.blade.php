<x-app-layout>
    <!-- Header with clean spacing -->
    <div class="max-w-7xl mx-auto px-6 pt-8 pb-4">
        <h2 class="font-black text-3xl text-body leading-tight flex items-center gap-3">
            <span class="bg-gradient-to-r from-purple-500 to-pink-500 text-white p-2 rounded-xl shadow-lg shadow-purple-500/20 text-xl">🛒</span>
            Boutique <span class="text-primary">IrreguLearn</span>
        </h2>
    </div>

    <div class="pb-20">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Main Shop Area -->
            <div class="lg:col-span-8 space-y-8">
               <!-- We remove the card container wrapper to let the component control its own beautiful background/cards -->
                <livewire:shop-manager />
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-4 space-y-6">
                <!-- Special Offers Card -->
                <div class="relative overflow-hidden bg-gradient-to-br from-orange-400 to-red-500 rounded-3xl p-6 text-white shadow-xl shadow-orange-500/20 group hover:scale-[1.02] transition">
                    <div class="absolute -right-6 -top-6 text-8xl opacity-10 rotate-12">🔥</div>
                    <h4 class="font-black text-lg mb-2 relative z-10">Offres Flash</h4>
                    <p class="text-white/90 text-sm relative z-10 leading-relaxed mb-4">
                        Des boosters d'XP et des items légendaires arrivent bientôt ! Reste connecté pour ne rien rater.
                    </p>
                    <div class="inline-block bg-white/20 backdrop-blur-md px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider">
                        Coming Soon
                    </div>
                </div>

                <!-- Support Card -->
                <div class="bg-surface border border-muted rounded-3xl p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="bg-gray-100 p-2 rounded-lg text-gray-500">🎧</div>
                        <h4 class="font-bold text-body">Besoin d'aide ?</h4>
                    </div>
                    <p class="text-sm text-muted leading-relaxed mb-4">
                        Un problème avec un achat ? Notre équipe est là pour t'aider à récupérer tes XP.
                    </p>
                    <a href="#" class="text-sm font-bold text-primary hover:underline">Contacter le support →</a>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>