@section('og_title', "Mes verbes du jour")
@section('og_description', "Ma sélection de verbes irréguliers pour aujourd'hui sur IrreguLearn !")
@section('og_image', route('share.image', ['type' => 'daily', 'identifier' => 'today']))
<x-app-layout>
    <div class="py-12 bg-app min-h-screen">
        <div class="max-w-6xl mx-auto px-6 space-y-12">

            <div class="card-surface p-10 md:p-16 rounded-[3rem] border border-muted relative overflow-hidden text-center">
                <div class="relative z-10">
                    <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-[0.2em] mb-6">
                        Mission du Jour
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-body tracking-tight uppercase mb-4">Tes verbes du jour</h2>
                    <p class="mt-2 text-muted max-w-xl mx-auto font-medium leading-relaxed mb-6">
                        Voici la sélection personnalisée pour aujourd'hui. <br class="hidden sm:block"> Prends quelques minutes pour les mémoriser avant de passer au test.
                    </p>
                    <div class="flex flex-wrap justify-center gap-3">
                        <x-share-button
                            :title="'Mes verbes du jour'"
                            :text="'Ma sélection de verbes irréguliers pour aujourd\'hui sur IrreguLearn !'"
                            :url="route('verbs.today')"
                        />
                        <button x-data="{ copied: false }" @click="navigator.clipboard.writeText('{{ route('share.image', ['type' => 'daily', 'identifier' => 'today']) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-primary/10 border border-primary/20 text-primary rounded-2xl font-bold text-sm hover:bg-primary/20 transition active:scale-95 shadow-sm">
                            <span x-show="!copied">🖼️ Partager l'image</span>
                            <span x-show="copied" x-cloak class="text-success">✅ Lien image copié !</span>
                        </button>
                    </div>
                </div>
                <!-- Decorative background text -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.02] select-none">
                    <span class="text-[20rem] font-black uppercase tracking-tighter">DAILY</span>
                </div>
            </div>

            <livewire:daily-verbs :$dailyVerbs />

            @if($dailyVerbs->count() > 0)
                <div class="flex justify-center pt-8">
                    <a href="{{ route('learn.session', ['mode' => 'daily']) }}"
                        class="group flex items-center gap-4 px-10 py-5 bg-primary text-surface font-black rounded-2xl shadow-2xl shadow-primary/30 hover:scale-105 transition-all text-lg active:scale-95">
                        <span class="text-2xl group-hover:rotate-12 transition-transform">🚀</span>
                        <span>PRATIQUER MAINTENANT</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
