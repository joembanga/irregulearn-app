<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IrreguLearn - Maîtrise les verbes irréguliers</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans text-gray-900 bg-white">

    <nav class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
        <div class="flex items-center gap-2">
            <div class="bg-indigo-600 text-white p-2 rounded-lg font-bold text-xl">IL</div>
            <span class="font-bold text-xl tracking-tight text-gray-900">Irregu<span
                    class="text-indigo-600">Learn</span></span>
        </div>

        <div class="flex items-center gap-4">
            @if (Route::has('login'))
            @auth
            <a href="{{ url('/dashboard') }}"
                class="font-semibold text-gray-600 hover:text-indigo-600 transition">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-gray-900">Connexion</a>
            <a href="{{ route('register') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full font-bold transition shadow-lg shadow-indigo-200">
                S'inscrire
            </a>
            @endauth
            @endif
        </div>
    </nav>

    <section class="mt-16 mx-auto max-w-7xl px-6 sm:mt-24 lg:mt-32 flex flex-col lg:flex-row items-center gap-12">
        <div class="lg:w-1/2 text-center lg:text-left">
            <div
                class="inline-flex items-center px-3 py-1 rounded-full border border-indigo-100 bg-indigo-50 text-indigo-600 text-sm font-medium mb-6">
                🚀 Disponible dès maintenant en RDC
            </div>
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-gray-900 leading-tight">
                Les verbes irréguliers,<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">enfin
                    domptés.</span>
            </h1>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                Arrête d'apprendre par cœur bêtement. Rejoins tes <span
                    class="font-bold text-gray-800">Classmates</span>, gagne des XP, maintiens ton Streak et deviens
                bilingue sans t'en rendre compte.
            </p>
            <div class="mt-10 flex items-center justify-center lg:justify-start gap-x-6">
                <a href="{{ route('register') }}"
                    class="rounded-xl bg-indigo-600 px-8 py-4 text-lg font-bold text-white shadow-xl hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition transform hover:-translate-y-1">
                    Commencer l'entraînement
                </a>
                <a href="#features" class="text-sm font-semibold leading-6 text-gray-900 flex items-center gap-1">
                    Comment ça marche <span aria-hidden="true">→</span>
                </a>
            </div>

            <div class="mt-8 flex items-center justify-center lg:justify-start gap-4 text-sm text-gray-500">
                <div class="flex -space-x-2">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
                        src="https://api.dicebear.com/9.x/avataaars/svg?seed=Felix" alt="" />
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
                        src="https://api.dicebear.com/9.x/avataaars/svg?seed=Aneka" alt="" />
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
                        src="https://api.dicebear.com/9.x/avataaars/svg?seed=Jude" alt="" />
                </div>
                <p>Rejoins +50 étudiants aujourd'hui</p>
            </div>
        </div>

        <div class="lg:w-1/2 relative">
            <div
                class="absolute top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
            </div>
            <div
                class="absolute top-0 -right-4 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000">
            </div>

            <div
                class="relative bg-white/80 backdrop-blur-lg border border-white/20 p-8 rounded-2xl shadow-2xl transform rotate-3 hover:rotate-0 transition duration-500">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Verbe du jour</span>
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Facile</span>
                </div>
                <h3 class="text-4xl font-black text-gray-800 mb-2">To Go</h3>
                <div class="space-y-2">
                    <div class="flex justify-between border-b py-2">
                        <span class="text-gray-500">Preterit</span>
                        <span class="font-bold text-indigo-600">Went</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-500">Participle</span>
                        <span class="font-bold text-indigo-600">Gone</span>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button class="w-full bg-gray-900 text-white py-3 rounded-lg font-bold text-sm">J'ai compris ! (+10
                        XP)</button>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-24 bg-gray-50 mt-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-indigo-600">Méthode IrreguLearn</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Tout ce qu'il faut pour ne
                    plus bégayer.</p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-3 lg:gap-y-16">

                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div
                                class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                🎮
                            </div>
                            Gamification
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">Gagne des XP, débloque des badges et monte
                            dans le classement. Apprendre devient un jeu.</dd>
                    </div>

                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div
                                class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                🔥
                            </div>
                            Mode Streak
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">Maintiens ta flamme allumée en pratiquant 2
                            minutes par jour. La régularité est la clé.</dd>
                    </div>

                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div
                                class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                🤝
                            </div>
                            Classmates
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">Invite tes amis, échangez des points et
                            défiez-vous dans le classement hebdomadaire.</dd>
                    </div>

                </dl>
            </div>
        </div>
    </section>

    @include('layouts.footer')

</body>

</html>