<footer class="bg-surface border-t border-muted py-12 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-1 md:col-span-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 mb-6">
                    <div class="bg-primary text-surface p-2 rounded-xl font-bold shadow-sm">IL</div>
                    <span class="font-black text-xl text-body tracking-tight">Irregu<span class="text-primary">Learn</span></span>
                </a>
                <p class="text-muted text-sm max-w-sm leading-relaxed">
                    Maîtrisez les verbes irréguliers anglais avec une approche moderne et récompensée. Déjà des milliers d'élèves progressent chaque jour.
                </p>
            </div>
            
            <div>
                <h4 class="font-bold text-body mb-6 uppercase text-[10px] tracking-[0.2em]">Application</h4>
                <nav class="flex flex-col gap-3 text-sm">
                    <a href="{{ route('learn.index') }}" class="text-muted hover:text-primary transition-colors font-medium">Apprendre</a>
                    <a href="{{ route('leaderboard') }}" class="text-muted hover:text-primary transition-colors font-medium">Classement</a>
                    <a href="{{ route('shop') }}" class="text-muted hover:text-primary transition-colors font-medium">Boutique</a>
                    <a href="{{ route('search') }}" class="text-muted hover:text-primary transition-colors font-medium">Recherche</a>
                </nav>
            </div>

            <div>
                <h4 class="font-bold text-body mb-6 uppercase text-[10px] tracking-[0.2em]">Légal</h4>
                <nav class="flex flex-col gap-3 text-sm">
                    <a href="{{ route('about') }}" class="text-muted hover:text-primary transition-colors font-medium">À propos</a>
                    <a href="{{ route('privacy') }}" class="text-muted hover:text-primary transition-colors font-medium">Confidentialité</a>
                    <li><a href="{{ route('contact') }}" class="text-muted hover:text-primary transition-colors font-medium">Contact</a></li>
                </nav>
            </div>
        </div>

        <div class="mt-16 pt-8 border-t border-muted/50 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-xs text-muted font-medium">
                &copy; {{ date('Y') }} IrreguLearn. Fait avec passion pour l'éducation.
            </p>
            <div class="text-[10px] text-muted uppercase tracking-widest font-bold">
                Kinshasa • Paris • Londres
            </div>
        </div>
    </div>
</footer>