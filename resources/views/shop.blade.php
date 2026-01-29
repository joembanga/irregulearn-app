<x-app-layout>
    <div class="py-2 bg-app min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-10 text-left">
                <h1 class="text-3xl md:text-4xl font-bold text-body tracking-">
                    {{ __('Boutique') }} <span class="text-primary">IrreguLearn</span>
                </h1>
                <p class="text-muted font-medium mt-2 text-lg">
                    {{ __('Utilise tes XP pour personnaliser ton expérience et progresser plus vite') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Main Shop Area -->
                <div class="lg:col-span-8">
                    <livewire:shop-manager />
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-4 space-y-6">
                    <!-- Special Offers Card -->
                    <div class="relative overflow-hidden bg-linear-to-br from-orange-500 to-red-600 rounded-2xl p-8 text-white shadow-xl shadow-orange-500/20 group transition-all duration-300 hover:scale-[1.02]">
                        <div class="absolute -right-6 -top-6 text-8xl opacity-10 rotate-12 group-hover:rotate-0 transition-transform duration-700">🔥</div>
                        <h4 class="font-bold text-xl mb-3 relative z-10">{{ __('Offres Flash') }}</h4>
                        <p class="text-white/90 text-sm relative z-10 leading-relaxed mb-6">
                            {{ __('Des boosters d\'XP et des items légendaires arrivent bientôt ! Reste connecté pour ne rien rater.') }}
                        </p>
                        <div class="inline-flex bg-white/20 backdrop-blur-md px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest">
                            {{ __('Arrive bientôt') }}
                        </div>
                    </div>

                    <!-- Support Card -->
                    <div class="bg-surface border border-muted rounded-2xl p-8 shadow-sm transition-all duration-300 hover:shadow-md">
                        <div class="flex items-center gap-4 mb-4 text-primary">
                            <div class="bg-primary/10 p-3 rounded-xl">
                                <x-lucide-help-circle class="size-6" />
                            </div>
                            <h4 class="font-bold text-lg text-body">{{ __('Besoin d\'aide ?') }}</h4>
                        </div>
                        <p class="text-muted font-medium leading-relaxed mb-6">
                            {{ __('Un problème avec un achat ? Notre équipe est là pour t\'aider à récupérer tes XP.') }}
                        </p>
                        <a href="{{ route('contact') }}" wire:navigate class="inline-flex items-center gap-2 text-sm font-bold text-primary hover:gap-3 transition-all">
                            <span>{{ __('Contacter le support') }}</span>
                            <x-lucide-arrow-right class="size-4" />
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>