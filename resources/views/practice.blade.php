<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">
                <h2 class="text-3xl font-black text-gray-900">Entraînement Libre</h2>
                <p class="text-gray-600">Choisis une catégorie pour réviser. Chaque bonne réponse te rapporte des XP !
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <livewire:quiz-engine :level="'beginner'" />
                    {{-- <button
                        class="bg-white p-6 rounded-3xl shadow-sm border-2 border-transparent hover:border-indigo-500 transition text-left group">
                        <div class="text-3xl mb-2">🌱</div>
                        <h3 class="text-xl font-bold">Les Essentiels</h3>
                        <p class="text-sm text-gray-500">{{ $stats['beginner'] }} verbes fréquents</p>
                        <div
                            class="mt-4 inline-block bg-indigo-100 text-indigo-700 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                            Démarrer</div>
                    </button> --}}
                    
                    <livewire:quiz-engine :level="'expert'" />
                    {{-- <button
                        class="bg-white p-6 rounded-3xl shadow-sm border-2 border-transparent hover:border-purple-500 transition text-left">
                        <div class="text-3xl mb-2">⚡</div>
                        <h3 class="text-xl font-bold">Mode Expert</h3>
                        <p class="text-sm text-gray-500">{{ $stats['expert'] }} verbes complexes</p>
                        <div
                            class="mt-4 inline-block bg-purple-100 text-purple-700 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                            Démarrer</div>
                    </button> --}}
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-indigo-900 rounded-3xl p-6 text-white shadow-xl">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <span>🏆</span> Champions de la semaine
                    </h3>
                    <div class="space-y-4">
                        @foreach($topThree as $index => $topUser)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-indigo-300 font-bold">#{{ $index + 1 }}</span>
                                <span class="font-medium">{{ $topUser->username }}</span>
                            </div>
                            <span class="text-xs bg-indigo-800 px-2 py-1 rounded text-indigo-200">
                                {{ number_format($topUser->xp_total) }} XP
                            </span>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('leaderboard') }}"
                        class="block text-center mt-6 text-sm text-indigo-300 hover:text-white underline">
                        Voir le classement complet
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

{{-- 
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <livewire:quiz-engine />
    </div>
</div> --}}