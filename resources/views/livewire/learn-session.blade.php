<div>
    @php
    $allDone = $dailyVerbs->where('pivot.is_learned', true)->count() >= 5;
    @endphp

    @if($allDone)
    <div class="card-surface rounded-2xl p-8 border border-success/20 shadow-lg text-center">
        <span class="text-6xl">🥳</span>
        <h2 class="text-2xl font-black text-success mt-4">Objectif atteint !</h2>
        <p class="text-success/80 mb-6">Tu as maîtrisé tes 5 verbes du jour. Reviens demain pour de nouveaux défis.</p>
        <a href="{{ route('dashboard') }}" class="inline-block bg-success text-white px-8 py-3 rounded-xl font-bold shadow-lg">Retour au Dashboard</a>
    </div>
    @else
    @endif
    @if($step === 'list')
    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white italic">Tes 5 verbes du jour</h2>
        <p class="text-accent font-medium">Mémorise les formes et les exemples avant de tester tes connaissances.</p>
    </div>

    <div class="space-y-6 mb-10">
        @foreach($dailyVerbs as $verb)
        <div class="card-surface p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-primary"></div>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $verb->infinitive }} <span class="text-gray-500 dark:text-gray-300 text-lg">({{ $verb->translation }})</span></h3>
                    <div class="mt-2 text-sm text-gray-700 dark:text-gray-300 italic">"I <strong>{{ $verb->past_simple }}</strong> to the market yesterday."</div>
                </div>
                <div class="flex gap-2">
                    <span class="px-3 py-1 rounded-lg font-mono font-bold text-sm bg-primary/10 dark:bg-gray-800 text-primary dark:text-primary/70">{{ $verb->past_simple }}</span>
                    <span class="px-3 py-1 rounded-lg font-mono font-bold text-sm bg-success/10 dark:bg-gray-800 text-success dark:text-success/70">{{ $verb->past_participle }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <button wire:click="startQuiz" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xl hover:opacity-95 transition shadow-2xl">JE SUIS PRÊT ! 🚀</button>

    @else
    <livewire:quiz-engine :restrictToVerbIds="$dailyVerbs->pluck('id')->toArray()" />
    @endif
</div>