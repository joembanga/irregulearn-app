<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ __('Maîtrise chirurgicale des verbes irréguliers anglais. Pas de superflu, juste de l\'efficacité via la répétition espacée.') }}">
    <meta property="og:title" content="{{ __('IrreguLearn - Maitrise Les verbes Irreguliers Anglais') }}">
    <meta property="og:description" content="{{ __('Maîtrise chirurgicale des verbes irréguliers anglais. Pas de superflu, juste de l\'efficacité via la répétition espacée.') }}">
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

<body
    class="antialiased font-sans text-body scroll-smooth bg-linear-to-b from-surface via-surface to-app/5 selection:bg-primary/20">
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
                <a href="{{ url('/dashboard') }}" wire:navigate class="font-bold text-sm text-primary hover:underline">
                    {{ __('Dashboard') }}
                </a>
                @else
                <a href="{{ route('login') }}" wire:navigate class="hidden sm:inline-block font-bold text-sm text-body hover:text-primary transition-colors">
                    {{ __('Se connecter') }}
                </a>
                <a href="{{ route('register') }}" wire:navigate class="bg-primary hover:bg-primary/90 text-surface px-6 py-2.5 rounded-full font-bold text-sm transition-all hover:shadow-lg hover:shadow-primary/30 active:scale-95">
                    {{ __('C\'est parti') }}
                </a>
                @endauth
                @endif
            </div>
        </nav>
    </header>

    <main class="relative overflow-hidden">
        <div class="max-w-3xl mx-auto px-6">
            <h1 class="text-3xl font-extrabold text-body mb-4">{{ __('Politique de confidentialité') }}</h1>
            <p class="text-muted mb-6">
                {{ __('Chez IrreguLearn, nous prenons la confidentialité de nos utilisateurs très au sérieux. Cette page explique quelles données nous collectons, pourquoi nous les utilisons et comment vous pouvez exercer vos droits.') }}
            </p>

            <h2 class="text-xl font-semibold text-body mt-6">{{ __('1. Données collectées') }}</h2>
            <p class="text-muted">
                {{ __('Nous collectons les informations nécessaires pour fournir le service : nom d\'utilisateur, email, progression, préférences et données liées aux verbes et exercices. Nous pouvons également collecter des informations techniques (logs, adresse IP) pour la sécurité et l\'amélioration du service.') }}
            </p>

            <h2 class="text-xl font-semibold text-body mt-6">{{ __('2. Utilisation') }}</h2>
            <p class="text-muted">
                {{ __('Les données servent à personnaliser l\'expérience, sauvegarder la progression, envoyer des notifications et améliorer le produit. Nous ne vendons pas vos données à des tiers.') }}
            </p>

            <h2 class="text-xl font-semibold text-body mt-6">{{ __('3. Sécurité') }}</h2>
            <p class="text-muted">
                {{ __('Nous appliquons des mesures raisonnables pour protéger vos informations. Toutefois, aucune transmission sur Internet n\'est totalement sécurisée.') }}
            </p>

            <h2 class="text-xl font-semibold text-body mt-6">{{ __('4. Vos droits') }}</h2>
            <p class="text-muted">
                {{ __('Vous pouvez demander l\'accès, la rectification ou la suppression de vos données en nous contactant via la page Contact.') }}
            </p>

            <p class="text-sm text-muted mt-8">{{ __('Dernière mise à jour :') }} {{ date('Y-m-d') }}</p>
        </div>
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
                        <li><a href="#sets" class="hover:text-primary transition-colors">{{ __('Sets d\'étude') }}</a>
                        </li>
                        <li><a href="#features"
                                class="hover:text-primary transition-colors">{{ __('Comment ça marche') }}</a></li>
                        <li><a href="{{ route('register') }}"
                                class="hover:text-primary transition-colors">{{ __('Tarifs') }}</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-black text-xs uppercase tracking-widest text-primary mb-6 italic">Support</h5>
                    <ul class="space-y-4 text-sm font-bold text-body">
                        <li><a href="#" wire:navigate class="hover:text-primary transition-colors">{{ __('Centre d\'aide') }}</a>
                        </li>
                        <li><a href="#" wire:navigate class="hover:text-primary transition-colors">{{ __('Contactez-nous') }}</a>
                        </li>
                        <li><a href="#" wire:navigate class="hover:text-primary transition-colors">{{ __('Confidentialité') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-black text-xs uppercase tracking-widest text-primary mb-6 italic">Social</h5>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 text-lg flex items-center justify-center hover:scale-[1.02] transition-all">𝕏</a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center hover:scale-[1.02] transition-all">
                            <x-lucide-instagram class="size-4 stroke-body fill-none" />
                        </a>
                        <a href="#" class="w-10 h-10 items-center justify-center hover:scale-[1.02] transition-all">
                            <x-lucide-facebook class="size-4 stroke-body fill-none" />
                        </a>
                    </div>
                </div>
                <livewire:toggle-lang-button />
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between pt-10 border-t border-muted/30">
                <p class="text-xs font-bold text-muted">© {{ date('Y') }} IrreguLearn.
                    {{ __('Fait avec ❤️ pour les apprenants d\'anglais.') }}
                </p>
                <div class="flex gap-6 mt-6 md:mt-0">
                    <a href="{{ route('terms') }}" wire:navigate
                        class="text-[10px] font-black uppercase tracking-widest text-muted hover:text-primary transition-colors">{{ __('Termes') }}</a>
                    <a href="{{ route('privacy') }}" wire:navigate
                        class="text-[10px] font-black uppercase tracking-widest text-muted hover:text-primary transition-colors">{{ __('Confidentialité') }}</a>
                    <a href="#"
                        class="text-[10px] font-black uppercase tracking-widest text-muted hover:text-primary transition-colors">{{ __('Cookies') }}</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>