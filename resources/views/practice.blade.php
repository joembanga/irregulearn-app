<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-8">

            <div class="lg:col-span-2 space-y-6">
                <h2 class="text-3xl font-black text-gray-900">Entraînement Libre</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <livewire:quiz-engine/>
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