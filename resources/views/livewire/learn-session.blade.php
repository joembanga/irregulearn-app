<div>
    @php
    $allDone = $dailyVerbs->where('pivot.is_learned', true)->count() >= 5;
    @endphp

    @if($allDone)
    <div class="text-center p-10 bg-emerald-50 rounded-3xl border-2 border-emerald-200">
        <span class="text-6xl">🥳</span>
        <h2 class="text-2xl font-black text-emerald-900 mt-4">Objectif atteint !</h2>
        <p class="text-emerald-700 mb-6">Tu as maîtrisé tes 5 verbes du jour. Reviens demain pour de nouveaux défis.</p>
        <a href="{{ route('dashboard') }}" class="bg-emerald-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg">
            Retour au Dashboard
        </a>
    </div>
    @else
    @endif
    @if($step === 'list')
    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-gray-900 italic">Tes 5 verbes du jour</h2>
        <p class="text-indigo-500 font-medium">Mémorise les formes et les exemples avant de tester tes connaissances.
        </p>
    </div>

    <div class="space-y-6 mb-10">
        @foreach($dailyVerbs as $verb)
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-indigo-500"></div>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-black text-gray-800">{{ $verb->infinitive }} <span
                            class="text-gray-400 text-lg">({{ $verb->translation }})</span></h3>
                    <div class="mt-2 text-sm text-gray-600 italic">
                        "I <strong>{{ $verb->past_simple }}</strong> to the market yesterday."
                    </div>
                </div>
                <div class="flex gap-2">
                    <span
                        class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg font-mono font-bold text-sm">{{ $verb->past_simple }}</span>
                    <span
                        class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-lg font-mono font-bold text-sm">{{ $verb->past_participle }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <button wire:click="startQuiz"
        class="w-full bg-gray-900 text-white py-5 rounded-2xl font-black text-xl hover:bg-black transition shadow-2xl">
        JE SUIS PRÊT ! 🚀
    </button>

    @else
    <livewire:quiz-engine :restrictToVerbIds="$dailyVerbs->pluck('id')->toArray()" />
    @endif
</div>