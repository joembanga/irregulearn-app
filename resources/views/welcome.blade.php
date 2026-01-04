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

<body class="antialiased font-sans text-body app-bg">

    <nav class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
        <div class="flex items-center gap-2">
            <div class="bg-primary text-surface p-2 rounded-lg font-bold text-xl">IL</div>
            <span class="font-bold text-xl tracking-tight text-body">Irregu<span
                    class="text-primary">Learn</span></span>
        </div>

        <div class="flex items-center gap-4">
            @if (Route::has('login'))
            @auth
            <a href="{{ url('/dashboard') }}"
                class="font-semibold text-muted hover:text-primary transition">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="font-medium text-muted hover:text-body">Connexion</a>
            <a href="{{ route('register') }}"
                class="bg-primary hover:bg-primary/90 text-surface px-5 py-2 rounded-full font-bold transition shadow-lg">
                S'inscrire
            </a>
            @endauth
            @endif
        </div>
    </nav>

    <section class="mt-4 mx-auto max-w-7xl px-6 sm:mt-4 lg:mt-6 flex flex-col lg:flex-row items-center gap-12">
        <div class="lg:w-1/2 text-center lg:text-left">
            <div
                class="inline-flex items-center px-3 py-1 rounded-full border border-primary/20 bg-primary/10 text-primary text-sm font-medium mb-6">
                🚀 Disponible dès maintenant en RDC
            </div>
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-body leading-tight">
                Les verbes irréguliers,<br>
                <span class="text-primary">enfin domptés.</span>
            </h1>
            <p class="mt-6 text-lg leading-8 text-muted">
                Arrête d'apprendre par cœur bêtement. Rejoins tes <span class="font-bold text-body">friendships</span>,
                gagne des XP, maintiens ton
                Streak et deviens
                bilingue sans t'en rendre compte.
            </p>
            <div class="mt-10 flex items-center justify-center lg:justify-start gap-x-6">
                <a href="{{ route('register') }}"
                    class="rounded-xl bg-primary px-8 py-4 text-lg font-bold text-surface shadow-xl hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent transition transform hover:-translate-y-1">
                    Commencer l'entraînement
                </a>
                <a href="#features" class="text-sm font-semibold leading-6 text-body flex items-center gap-1">
                    Comment ça marche <span aria-hidden="true">→</span>
                </a>
            </div>

            <div class="mt-8 flex items-center justify-center lg:justify-start gap-4 text-sm text-muted">
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
                class="absolute top-0 -left-4 w-72 h-72 bg-primary/30 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
            </div>
            <div
                class="absolute top-0 -right-4 w-72 h-72 bg-primary/30 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-8 left-20 w-72 h-72 bg-primary/30 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000">
            </div>

            <div
                class="relative card-surface glass border border-muted p-8 rounded-2xl shadow-2xl transform rotate-3 hover:rotate-0 transition duration-500">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-bold text-muted uppercase tracking-wider">Verbe du jour</span>
                    <span class="bg-success-10 text-success px-2 py-1 rounded text-xs font-bold">Facile</span>
                </div>
                <h3 class="text-4xl font-black text-body mb-2">To Go</h3>
                <div class="space-y-2">
                    <div class="flex justify-between border-b py-2">
                        <span class="text-muted">Preterit</span>
                        <span class="font-bold text-primary">Went</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-muted">Participle</span>
                        <span class="font-bold text-primary">Gone</span>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-muted">
                    <button
                        class="w-full bg-primary text-surface py-3 rounded-lg font-bold text-sm hover:opacity-95">J'ai
                        compris ! (+10 XP)</button>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-8 mt-6">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-primary">Méthode IrreguLearn</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-body sm:text-4xl">Tout ce qu'il faut pour ne plus
                    bégayer.</p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-3 lg:gap-y-16">

                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-body">
                            <div
                                class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-primary">
                                🎮
                            </div>
                            Gamification
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-muted">Gagne des XP, débloque des badges et monte
                            dans le classement. Apprendre devient un jeu.</dd>
                    </div>

                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-body">
                            <div
                                class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-primary">
                                🔥
                            </div>
                            Mode Streak
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-muted">Maintiens ta flamme allumée en pratiquant 2
                            minutes par jour. La régularité est la clé.</dd>
                    </div>

                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-body">
                            <div
                                class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-primary">
                                🤝
                            </div>
                            friendships
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-muted">Invite tes amis, échangez des points et
                            défiez-vous dans le classement hebdomadaire.</dd>
                    </div>

                </dl>
            </div>
        </div>
    </section>

    <section id="testimonials" class="py-12">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-primary">Ils ont progressé</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-body sm:text-4xl">Témoignages</p>
            </div>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="card-surface p-6 rounded-2xl shadow-sm border border-muted">
                    <p class="text-muted">"Grâce à IrreguLearn j'ai enfin compris les verbes irréguliers. 10 minutes par
                        jour et c'est réglé."</p>
                    <div class="mt-4 font-bold">— Amina, Étudiante</div>
                </div>
                <div class="card-surface p-6 rounded-2xl shadow-sm border border-muted">
                    <p class="text-muted">"Le système d'XP m'a motivé à m'entraîner tous les jours. Mon niveau s'est
                        clairement amélioré."</p>
                    <div class="mt-4 font-bold">— Jean, Professeur</div>
                </div>
                <div class="card-surface p-6 rounded-2xl shadow-sm border border-muted">
                    <p class="text-muted">"Les sessions courtes et ciblées sont parfaites avant un examen."</p>
                    <div class="mt-4 font-bold">— Fatou, Étudiante</div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

</body>

</html>