<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="{{ __('Maîtrise chirurgicale des verbes irréguliers anglais. Pas de superflu, juste de l\'efficacité via la répétition espacée.') }}">
    <meta property="og:title" content="{{ __('IrreguLearn - Maitrise Les verbes Irreguliers Anglais') }}">
    <meta property="og:description"
        content="{{ __('Maîtrise chirurgicale des verbes irréguliers anglais. Pas de superflu, juste de l\'efficacité via la répétition espacée.') }}">
    <meta property="og:type" content="website">
    <title>{{ __('IrreguLearn - Maitrise Les verbes Irreguliers Anglais') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glass-card {
            background: rgba(32, 32, 64, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="antialiased font-sans text-body scroll-smooth bg-linear-to-b from-surface via-surface to-app/5 selection:bg-primary/20">
    <!-- Navigation -->
    <header class="fixed left-0 right-0 top-0 z-50 border-b border-primary/10 backdrop-blur-xl bg-surface/80">
        <nav class="flex items-center justify-between px-6 sm:px-12 py-5 max-w-8xl mx-auto">
            <a href="/" wire:navigate class="flex items-center gap-3 group">
                <div class="bg-primary text-surface p-2.5 rounded-xl font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                    IL
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-xl tracking-tight text-body">IrreguLearn</span>
                    <span class="text-[10px] uppercase tracking-widest text-primary font-bold">{{ __('Maitrise l\'anglais') }}</span>
                </div>
            </a>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/dashboard') }}" wire:navigate class="font-bold text-sm md:text-base text-primary hover:underline">
                    {{ __('Dashboard') }}
                </a>
                @else
                <a href="{{ route('login') }}" wire:navigate
                    class="hidden sm:inline-block font-bold text-sm text-body md:text-base hover:text-primary transition-colors">
                    {{ __('Se connecter') }}
                </a>
                <a href="{{ route('register') }}" wire:navigate
                    class="bg-primary hover:bg-primary/90 text-surface px-6 py-2.5 md:text-base rounded-full font-bold text-sm transition-all hover:shadow-lg hover:shadow-primary/30 active:scale-95">
                    {{ __('C\'est parti') }}
                </a>
                @endauth
                @endif
            </div>
        </nav>
    </header>

    <main class="relative overflow-hidden">
        <!-- Background Blobs -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-full -z-10">
            <div class="absolute top-[10%] -left-[10%] w-100 h-125 bg-accent md:bg-primary rounded-full blur-[200px] animate-pulse"></div>
            <div class="absolute top-[2%] md:top-[5%] -right-[10%] w-100 h-20 md:w-125 md:h-40 bg-primary rounded-full blur-[200px] animate-pulse animation-delay-4000"></div>
            <div class="hidden md:block absolute top-[20%] -right-[10%] w-100 h-125 bg-accent rounded-full blur-[200px] animation-delay-3000"></div>
        </div>

        <!-- Hero Section -->
        <section class="pt-32 pb-20 sm:pt-48 sm:pb-32 px-6 h-screen">
            <div class="max-w-4xl mx-auto text-left md:text-center">
                <h1 class="text-5xl sm:text-6xl font-black text-body leading-[1.1] mb-8">
                    {{ __('La façon la plus fun de maitriser les verbes irréguliers en anglais') }}
                </h1>

                <p class="text-xl text-muted font-medium mb-12 max-w-2xl mx-auto leading-relaxed">
                    {{ __('Les listes passives et les applications généralistes sont trop lentes ; la maîtrise exige une vitesse de rappel automatique.') }}
                </p>

                <!-- Prominent Search Bar -->
                <form method="GET" action="{{ route('search') }}" class="relative max-w-2xl mx-auto group">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <x-lucide-search class="size-6 stroke-muted fill-none inline" />
                    </div>
                    <input name="q" type="text" placeholder="{{ __('Rechercher un verbe... (ex: Go, Speak)') }}"
                        class="w-full pl-14 pr-5 py-4 bg-surface border-2 border-primary/10 rounded-2xl text-base font-medium focus:border-primary focus:ring-0 shadow-xl shadow-primary/5 transition-all placeholder:text-muted/50">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 bg-primary text-surface px-4 py-3 rounded-xl font-bold text-sm active:scale-95 transition-all">
                        {{ __('Trouver') }}
                    </button>
                </form>
            </div>
        </section>

        <!-- Ready to Study? Section (Study Sets) -->
        <section id="sets" class="py-20 px-6 bg-app">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <h2 class="text-4xl sm:text-5xl font-black text-body leading-tight mb-2">{{ __('Prêt à apprendre ?') }}</h2>
                        <p class="text-muted font-medium">{{ __('Choisissez un niveau et commencez à maîtriser l\'anglais dès aujourd\'hui.') }}</p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php
                    $sets = [
                    ['title' => __('Les Essentiels'), 'count' => '25 Verbs', 'icon' => 'flame', 'color' => 'primary', 'desc' =>
                    __('Les verbes indispensables pour tout débutant.')],
                    ['title' => __('Intermédiaire'), 'count' => '40 Verbs', 'icon' => 'target', 'color' => 'accent',
                    'desc' => __('Maîtrisez les formes complexes avec des exercices contextuels.')],
                    ['title' => __('Niveau Expert'), 'count' => '60 Verbs', 'icon' => 'trophy', 'color' => 'warning', 'desc' =>
                    __('Verbes rares et exigeants pour les apprenants avancés.')],
                    ];
                    @endphp

                    @foreach($sets as $set)
                    <div class="glass-card group bg-surface border-muted p-8 rounded-xl transition-all hover:-translate-y-2 hover:shadow-2xl hover:shadow-primary/10">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-4xl group-hover:scale-110 transition-transform"><x-icon name="lucide-{{ $set['icon'] }}" class="size-10 shrink-0" /></span>
                            <span class="text-xs font-black uppercase tracking-widest text-[#{{ $set['color'] === 'primary' ? '3f25e7' : ($set['color'] == 'accent' ? '3b82f6' : 'f59e0b') }}]">{{ $set['count'] }}+</span>
                        </div>
                        <h3 class="text-2xl font-black text-body mb-3">{{ $set['title'] }}</h3>
                        <p class="text-muted text-lg font-medium mb-8 leading-relaxed">
                            {{ $set['desc'] }}
                        </p>
                        <a href="{{ route('register') }}"
                            class="block w-full text-center py-4 rounded-2xl font-bold bg-primary text-surface transition-all">
                            {{ __('Commencer l\'entraînement') }}
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-32 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-20 items-center">
                    <div>
                        <h2 class="text-4xl sm:text-5xl font-black text-body leading-tight mb-8">
                            {{ __('L\'apprentissage sans friction.') }}
                        </h2>

                        <div class="space-y-10">
                            <div class="flex gap-6">
                                <div class="shrink-0 w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-xl">
                                    <x-lucide-brain class="size-8 shrink-0" />
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-body mb-2">{{ __('Répétition Espacée (SRS)') }}</h4>
                                    <p class="text-muted text-sm leading-relaxed">{{ __('Nos algorithmes forcent le rappel à des intervalles critiques pour éliminer le décalage mental et garantir la rétention à long terme.') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-6">
                                <div class="shrink-0 w-12 h-12 bg-warning/10 rounded-xl flex items-center justify-center text-xl">
                                    <x-lucide-gamepad-2 class="size-8 shrink-0" />
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-body mb-2">{{ __('Gamification Axée sur les Résultats') }}</h4>
                                    <p class="text-muted text-sm leading-relaxed">{{ __('La pratique à haut volume n\'est pas un jeu—c\'est une nécessité. Nous utilisons des mécaniques de jeu pour suivre et propulser vos progrès.') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-6">
                                <div class="shrink-0 w-12 h-12 bg-success/10 rounded-xl flex items-center justify-center text-xl">
                                    <x-lucide-users class="size-8 shrink-0" />
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-body mb-2">{{ __('Performance Compétitive') }}</h4>
                                    <p class="text-muted text-sm leading-relaxed">{{ __('Comparez votre vitesse de rappel et votre précision. L\'efficacité est la seule métrique qui compte.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <!-- Preview Card -->
                        <div class="bg-surface rounded-3xl p-8 shadow-2xl border border-primary/10 animate-float">
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-linear-to-br from-primary to-accent"></div>
                                    <div>
                                        <p class="text-xs font-bold text-body">New Challenge</p>
                                        <p class="text-[10px] text-muted">Past Simple Test</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-success/10 text-success text-[10px] font-black rounded-full">
                                    +50 XP
                                </span>
                            </div>
                            <div class="text-center py-10">
                                <p class="text-muted text-sm mb-2 uppercase tracking-widest font-bold">Infinitive</p>
                                <h3 class="text-5xl font-black text-body mb-10">To Choose</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-surface border-2 border-primary/20 p-4 rounded-2xl text-center">
                                        <p class="text-[10px] text-muted uppercase font-bold mb-1">Past Simple</p>
                                        <p class="text-xl font-black text-primary">Chose</p>
                                    </div>
                                    <div class="bg-surface border-2 border-primary/20 p-4 rounded-2xl text-center">
                                        <p class="text-[10px] text-muted uppercase font-bold mb-1">Participle</p>
                                        <p class="text-xl font-black text-primary">Chosen</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Decor -->
                        <div
                            class="absolute -top-10 -right-10 w-40 h-40 bg-accent/20 rounded-full blur-3xl -z-10 animate-pulse">
                        </div>
                        <div
                            class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary/20 rounded-full blur-3xl -z-10 animation-delay-4000">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 bg-primary rounded-[3rem] mx-6">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid md:grid-cols-4 gap-12 text-center text-surface">
                    <div>
                        <p class="text-4xl font-black mb-1">500+</p>
                        <p class="text-sm font-bold opacity-70">{{ __('Étudiants Actifs') }}</p>
                    </div>
                    <div>
                        <p class="text-4xl font-black mb-1">150+</p>
                        <p class="text-sm font-bold opacity-70">{{ __('Verbes Maîtrisés') }}</p>
                    </div>
                    <div class="flex flex-col items-center justify-center -m-4">
                        <p class="text-4xl font-black"><x-lucide-infinity class="size-14 stroke-3 stroke-body fill-none inline" /></p>
                        <p class="text-sm font-bold opacity-70">{{ __('Exercices') }}</p>
                    </div>
                    <div>
                        <p class="text-4xl font-black mb-1">4.9/5</p>
                        <p class="text-sm font-bold opacity-70">{{ __('Note Utilisateurs') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-40 px-6 text-center">
            <h2 class="text-4xl sm:text-6xl font-black text-body mb-10">
                {{ __('Commencer mon apprentissage') }}
            </h2>
            <p class="text-xl text-muted font-medium mb-12 max-w-2xl mx-auto">
                {{ __('Rejoignez un environnement haute performance conçu pour une maîtrise rapide. Pas de superflu, juste des résultats.') }}
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ route('register') }}" wire:navigate
                    class="bg-primary hover:bg-primary/90 text-surface px-12 py-6 rounded-2xl font-bold text-xl hover:-translate-y-1 active:scale-95 transition-all">
                    {{ __('S\'inscrire gratuitement') }}
                </a>
                <a href="{{ route('login') }}" wire:navigate class="font-bold text-body hover:text-primary transition-colors flex items-center gap-2 group">
                    {{ __('Se connecter à votre compte') }}
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-primary/10 pt-20 pb-10 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-12 mb-20">
                <div class="col-span-2 lg:col-span-1">
                    <a href="/" wire:navigate class="flex items-center gap-3 w-fit mb-6">
                        <div class="bg-primary text-surface p-2 rounded-lg font-bold text-sm">IL</div>
                        <span class="font-bold text-lg text-body">IrreguLearn</span>
                    </a>
                    <p class="text-sm text-muted font-medium leading-relaxed">
                        {{ __('Maîtriser les verbes irréguliers anglais via la gamification et la précision technique.') }}
                    </p>
                </div>
                <div>
                    <h5 class="font-black text-xs uppercase tracking-widest text-primary mb-6 italic">Product</h5>
                    <ul class="space-y-4 text-sm font-bold text-body">
                        <li>
                            <a href="/#sets" class="hover:text-primary transition-colors">{{ __('Sets d\'étude') }}</a>
                        </li>
                        <li>
                            <a href="/#features" class="hover:text-primary transition-colors">{{ __('Comment ça marche') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="hover:text-primary transition-colors">{{ __('Tarifs') }}</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-black text-xs uppercase tracking-widest text-primary mb-6 italic">Support</h5>
                    <ul class="space-y-4 text-sm font-bold text-body">
                        <li>
                            <a href="#" wire:navigate class="hover:text-primary transition-colors">{{ __('Centre d\'aide') }}</a>
                        </li>
                        <li>
                            <a href="#" wire:navigate class="hover:text-primary transition-colors">{{ __('Contactez-nous') }}</a>
                        </li>
                        <li>
                            <a href="#" wire:navigate class="hover:text-primary transition-colors">{{ __('Confidentialité') }}</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-black text-xs uppercase tracking-widest text-primary mb-6 italic">Social</h5>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 flex items-center justify-center text-xl hover:scale-[1.02] transition-all"><span>𝕏</span></a>
                        <a href="#" class="w-10 h-10 hover:scale-[1.02] flex items-center justify-center transition-all"><x-lucide-instagram class="size-5 stroke-body fill-none"/></a>
                        <a href="#" class="w-10 h-10 hover:scale-[1.02] flex items-center justify-center transition-all"><x-lucide-facebook class="size-5    stroke-body fill-none" /></a>
                    </div>
                </div>
                <div>
                    <livewire:toggle-lang-button />
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between pt-10 border-t border-muted/30">
                <p class="text-xs text-center font-bold text-muted">© {{ date('Y') }} IrreguLearn.</p>
                <div class="flex gap-6 mt-6 md:mt-0">
                    <a href="{{ route('terms') }}" wire:navigate class="text-[10px] font-black uppercase tracking-widest text-muted hover:text-primary transition-colors">{{ __('Termes') }}</a>
                    <a href="{{ route('privacy') }}" wire:navigate class="text-[10px] font-black uppercase tracking-widest text-muted hover:text-primary transition-colors">{{ __('Confidentialité') }}</a>
                    <a href="#" class="text-[10px] font-black uppercase tracking-widest text-muted hover:text-primary transition-colors">{{ __('Cookies') }}</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>