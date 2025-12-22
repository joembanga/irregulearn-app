<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de Bord de') }} {{ $user->first_name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500 uppercase">XP Total</p>
                    <p class="text-3xl font-black text-indigo-600">{{ number_format($user->xp_total) }}</p>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500 uppercase">Série actuelle</p>
                    <p class="text-3xl font-black text-orange-500">{{ $user->current_streak }} jours 🔥</p>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500 uppercase">Vies restantes</p>
                    <p class="text-3xl font-black text-red-500">{{ $user->lives }} / 5 ❤️</p>
                
                    @if($user->lives < 5) @php $nextLifeAt=\Carbon\Carbon::parse($user->last_life_lost_at)->addHour();
                        @endphp
                        <p class="text-xs text-gray-400 mt-2 italic">
                            Prochaine vie dans **{{ now()->diffInMinutes($nextLifeAt) }} min**
                        </p>
                        @endif
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500 uppercase">Niveau</p>
                    <p class="text-3xl font-black text-purple-600">Apprenti</p>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="relative h-32 w-32 flex items-center justify-center">
                        <svg class="h-full w-full" viewBox="0 0 36 36">
                            <path class="text-gray-200" stroke-width="3" stroke="currentColor" fill="none"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-indigo-600" stroke-width="3"
                                stroke-dasharray="{{ $progressPercent }}, 100" stroke-linecap="round"
                                stroke="currentColor" fill="none"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <span class="absolute text-xl font-black text-gray-800">{{ round($progressPercent) }}%</span>
                    </div>

                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Ta maîtrise des verbes</h3>
                        <p class="text-gray-600 mb-4">Tu as appris <strong>{{ $learnedVerbsCount }}</strong> verbes sur
                            un total de <strong>{{ $totalVerbs }}</strong>. Continue comme ça !</p>
                        <a href="{{ route('learn') }}"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition">
                            Continuer l'apprentissage
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Mes Classmates</h3>
                    <a href="{{ route('leaderboard', ['filter' => 'classmates']) }}"
                        class="text-indigo-600 font-bold text-sm hover:underline">
                        Voir le classement →
                    </a>
                </div>
            
                @php
                $classmates = auth()->user()->classmates; // Assure-toi d'avoir la relation dans User.php
                @endphp
            
                <div class="flex flex-wrap gap-4">
                    @forelse($classmates as $friend)
                    <a href="{{ route('profile.public', $friend->username) }}" class="group flex flex-col items-center">
                        <div
                            class="w-14 h-14 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold border-2 border-transparent group-hover:border-indigo-500 transition shadow-sm mb-2 text-lg">
                            {{ substr($friend->username, 0, 1) }}
                        </div>
                        <span class="text-xs font-medium text-gray-600 group-hover:text-indigo-600">{{ $friend->username }}</span>
                    </a>
                    @empty
                    <div class="flex items-center gap-4 text-gray-400 italic text-sm">
                        <p>Tu n'as pas encore de classmates. Trouve-les dans le classement !</p>
                        <a href="{{ route('leaderboard') }}"
                            class="px-4 py-2 bg-gray-100 rounded-xl text-gray-600 not-italic font-bold text-xs hover:bg-gray-200">Chercher</a>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h4 class="text-lg font-bold mb-4">Objectif quotidien</h4>
                    <div class="space-y-4">
                        <div
                            class="flex justify-between items-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="font-medium">Nombre de verbes par jour</span>
                            <span class="text-indigo-600 font-bold">{{ $user->daily_target }} verbes</span>
                        </div>
                        <p class="text-xs text-gray-400 italic">Modifier l'objectif dans les paramètres du profil.</p>
                    </div>
                </div>

                <div class="bg-indigo-900 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h4 class="text-lg font-bold mb-2">Prêt pour un test ?</h4>
                        <p class="text-indigo-200 mb-6 text-sm">Entraîne-toi sur tous les verbes que tu as déjà vus pour
                            ne pas les oublier.</p>
                        <a href="{{ route('practice') }}"
                            class="bg-white text-indigo-900 px-6 py-3 rounded-xl font-bold text-sm hover:bg-indigo-50 transition">
                            Mode Entraînement
                        </a>
                    </div>
                    <div class="absolute -right-10 -bottom-10 text-9xl opacity-10">📖</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>