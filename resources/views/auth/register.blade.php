<x-guest-layout>
    @if (session('error'))
    <div class="mb-6 p-4 bg-danger-10 border-l-4 border-danger text-danger rounded-r-2xl text-sm font-medium animate-in fade-in slide-in-from-top-2 duration-300">
        <div class="flex items-center gap-3">
            <span class="text-lg">⚠️</span>
            <p>{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <div class="space-y-8">
        <div class="text-center">
            <h2 class="text-3xl font-black text-body tracking-tight">Créer un compte</h2>
            <p class="mt-2 text-muted font-medium">Rejoins IrreguLearn et commence à maîtriser les verbes.</p>
        </div>

        <livewire:auth.register-form />


        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-muted/50"></div>
            </div>
            <div class="relative flex justify-center text-xs">
                <span class="px-4 bg-surface text-muted font-bold uppercase tracking-widest">ou</span>
            </div>
        </div>

        <a href="{{ route('auth.google') }}"
            class="flex items-center justify-center gap-3 w-full px-6 py-4 bg-surface border border-muted rounded-2xl font-bold text-body hover:bg-muted/5 transition-all duration-200 hover:scale-[1.01] active:scale-[0.99] shadow-sm">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4"
                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                <path fill="#34A853"
                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                <path fill="#FBBC05"
                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" />
                <path fill="#EA4335"
                    d="M12 5.38c1.62 0 3.06.56 4.21 1.63l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
            </svg>
            <span>S'inscrire avec Google</span>
        </a>

        <p class="text-center text-sm text-muted">
            Déjà inscrit ? 
            <a href="{{ route('login') }}" wire.navigate class="font-bold text-primary hover:text-primary/80 transition-colors">
                Connecte-toi
            </a>
        </p>
    </div>
</x-guest-layout>