@php
$userLevel = null;
if ($user->xp_total >= 0 && $user->xp_total < 5000 ) { 
    $userLevel="Apprenti" ;
} elseif ($user->xp_total >= 5000 && $user->xp_total < 10000 ) { 
    $userLevel="Niveau 2" ;
} elseif ($user->xp_total >= 10000 && $user->xp_total < 30000 ) { 
    $userLevel="Niveau 3" ;
} elseif ($user->xp_total >= 30000 && $user->xp_total < 50000 ) {
    $userLevel="Niveau 4" ;
} elseif ($user->xp_total >= 50000) {
    $userLevel = "God";
}
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Heureux de te revoir') }} {{ $user->firstname }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-8 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-3  gap-6">

                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm font-medium text-gray-500 uppercase">XP Disponibles</p>
                    <p class="text-3xl font-black text-primary">
                        {{ number_format($user->xp_balance) }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm font-medium text-gray-500 uppercase">Série actuelle</p>
                    <p class="text-3xl font-black text-orange-500">{{ $user->current_streak }} jours 🔥</p>
                </div>
                
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm font-medium text-gray-500 uppercase">Niveau</p>
                    <p class="text-3xl font-black text-purple-600">{{ $userLevel }}</p>
                </div>

            </div>
            
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex flex-col md:flex-row items-center gap-8">

                    <div class="relative h-32 w-32 flex items-center justify-center">
                        <svg class="h-full w-full" viewBox="0 0 36 36">
                            <path class="text-gray-200" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-primary" stroke-width="3" stroke-dasharray="{{ $progressPercent }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <span class="absolute text-xl font-black text-gray-800 dark:text-white">{{ round($progressPercent) }}%</span>
                    </div>

                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Ta maîtrise des verbes</h3>
                        <p class="text-gray-600 mb-4">Tu as appris <strong>{{ $learnedVerbsCount }}</strong> verbes sur un total de <strong>{{ $totalVerbs }}</strong>. Continue comme ça ! </p>
                        <a href="{{ route('learn') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition">
                            Continuer l'apprentissage
                        </a>
                    </div>

                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Mes classmates</h3>
                    <a href="{{ route('leaderboard', ['filter' => 'friendships']) }}" class="text-primary font-bold text-sm hover:underline">
                        Voir le classement →
                    </a>
                </div>
                @php
                $friends = auth()->user()->friends(); // Assure-toi d'avoir la relation dans User.php
                @endphp
                <div class="flex flex-wrap gap-4">
                    @forelse($friends as $friend)
                    <a href="{{ route('profile.public', $friend->username) }}"
                        class="group flex flex-col items-center">
                        <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold border-2 border-transparent group-hover:border-primary transition shadow-sm mb-2 text-lg">
                            {{ substr($friend->username, 0, 1) }}
                        </div>
                        <span class="text-xs font-medium text-gray-600 group-hover:text-primary">{{ $friend->username }}</span>
                    </a>
                    @empty
                        <div class="flex items-center gap-4 text-gray-400 dark:text-gray-400 italic text-sm">
                        <p>Tu n'as pas encore de friendships. Trouve-les dans le classement !</p>
                        <a href="{{ route('leaderboard') }}"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-800 rounded-xl text-gray-600 dark:text-gray-200 not-italic font-bold text-xs hover:bg-gray-200 dark:hover:bg-gray-700">Chercher</a>
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h4 class="text-lg font-bold mb-4">Objectif quotidien</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-2xl border border-gray-100 dark:border-gray-700">
                            <span class="font-medium">Nombre de verbes par jour</span>
                            <span class="text-primary font-bold">{{ $user->daily_target }} verbes</span>
                        </div>
                        <p class="text-xs text-gray-400 italic">Modifier l'objectif dans les paramètresdu profil.</p>
                    </div>
                </div>
                <div class="bg-primary/95 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h4 class="text-lg font-bold mb-2">Prêt pour un test ?</h4>
                        <p class="text-primary/30 mb-6 text-sm">
                            Entraîne-toi sur tous les verbes que tu as déjà vus pour ne pas les oublier.
                        </p>
                        <a href="{{ route('practice') }}" class="bg-white text-primary/95 px-6 py-3 rounded-xl font-bold text-sm hover:bg-primary/10 transition">
                            Mode Entraînement
                        </a>
                    </div>
                    <div class="absolute -right-10 -bottom-10 text-9xl opacity-10">📖</div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <livewire:dashboard />
    </div>
</x-app-layout>