<footer class="bg-surface border-t border-muted transition-colors duration-300">
    <div class="mx-auto max-w-7xl px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-8 items-start">

        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-primary text-surface p-2 rounded-md font-bold text-lg">IL</div>
                <div>
                    <div class="font-bold text-lg text-body">IrreguLearn</div>
                    <div class="text-sm text-muted">Maîtrise les verbes irréguliers, pas à pas.
                    </div>
                </div>
            </div>
            <p class="text-xs leading-5 text-muted">&copy; {{ date('Y') }} IrreguLearn — Tous
                droits réservés.</p>
            <div class="flex items-center gap-3 mt-3">
                <a href="#" class="text-muted hover:text-primary">Twitter</a>
                <a href="#" class="text-muted hover:text-primary">Instagram</a>
                <a href="#" class="text-muted hover:text-primary">Discord</a>
            </div>
        </div>

        <div class="flex flex-col">
            <h4 class="text-sm font-semibold text-body mb-3">Ressources</h4>
            <nav class="flex flex-col gap-2 text-sm">
                <a href="/about" class="text-muted hover:text-primary">À propos</a>
                <a href="/privacy" class="text-muted hover:text-primary">Politique de confidentialité</a>
                <a href="/terms" class="text-muted hover:text-primary">Conditions d'utilisation</a>
                <a href="/contact" class="text-muted hover:text-primary">Contact</a>
            </nav>
        </div>

        <div class="flex flex-col items-start md:items-end">
            {{-- <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Thème</h4>
            <div class="flex items-center gap-3">
                <button id="theme-toggle" type="button" aria-label="Changer le thème"
                    class="inline-flex h-9 w-16 items-center rounded-full bg-gray-200 dark:bg-gray-700 p-1">
                    <span id="theme-toggle-circle"
                        class="inline-block h-7 w-7 rounded-full bg-white dark:bg-gray-800 shadow transform transition-transform"></span>
                </button>
            </div>
            <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">Mode clair/sombre — ton choix est sauvegardé.</p> --}}
            <h4 class="text-sm font-semibold text-body mb-3">Contact</h4>
            <div class="text-sm text-muted">hello@irregulearn.example</div>
            <p class="mt-4 text-xs text-muted">Support disponible en semaine • Kinshasa</p>
        </div>

    </div>
</footer>

{{-- <script>
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleCircle = document.getElementById('theme-toggle-circle');

    function setThemeVisual(isDark) {
        if (isDark) {
            themeToggleCircle.style.transform = 'translateX(32px)';
        } else {
            themeToggleCircle.style.transform = 'translateX(0)';
        }
    }

    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        setThemeVisual(true);
    } else {
        document.documentElement.classList.remove('dark');
        setThemeVisual(false);
    }

    themeToggleBtn.addEventListener('click', function() {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
            setThemeVisual(false);
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
            setThemeVisual(true);
        }
    });
</script> --}}