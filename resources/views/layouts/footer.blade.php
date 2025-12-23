<footer class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 transition-colors duration-300">
    <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">

        <div class="mt-8 md:order-1 md:mt-0">
            <div class="flex items-center gap-2 mb-4">
                <div class="bg-indigo-600 text-white p-1.5 rounded-lg font-bold text-lg">IL</div>
                <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">Irregu<span
                        class="text-indigo-600">Learn</span></span>
            </div>
            <p class="text-xs leading-5 text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} IrreguLearn, Kinshasa. <br class="hidden md:inline">Fait avec ❤️ pour les
                étudiants congolais.
            </p>
        </div>

        <div class="flex justify-center space-x-6 md:order-2">
            <a href="#"
                class="text-sm text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition">À
                propos</a>
            <a href="#"
                class="text-sm text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition">Politique
                de Confidentialité</a>
            <a href="#"
                class="text-sm text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition">CGU</a>
            <a href="#"
                class="text-sm text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition">Contact</a>
        </div>

        <div class="flex justify-end md:order-3 mt-8 md:mt-0">
            <button id="theme-toggle" type="button"
                class="group relative inline-flex h-9 w-16 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-gray-200 dark:bg-gray-700 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 dark:focus:ring-offset-gray-900">

                <span class="sr-only">Changer le thème</span>

                <span id="theme-toggle-circle"
                    class="pointer-events-none relative inline-block h-8 w-8 translate-x-0 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out dark:translate-x-7">

                    <span id="sun-icon"
                        class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity duration-100 ease-out opacity-100 dark:opacity-0">
                        <svg class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                    </span>

                    <span id="moon-icon"
                        class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity duration-100 ease-out opacity-0 dark:opacity-100">
                        <svg class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                        </svg>
                    </span>
                </span>
            </button>
        </div>
    </div>
</footer>

<script>
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleCircle = document.getElementById('theme-toggle-circle');
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    // 1. Vérifier la préférence au chargement
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        updateToggleVisuals(true);
    } else {
        document.documentElement.classList.remove('dark');
        updateToggleVisuals(false);
    }

    // 2. Gestion du clic
    themeToggleBtn.addEventListener('click', function() {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
            updateToggleVisuals(false);
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
            updateToggleVisuals(true);
        }
    });

    // Fonction pour mettre à jour les classes CSS du bouton (Animation)
    function updateToggleVisuals(isDark) {
        if (isDark) {
            themeToggleCircle.classList.remove('translate-x-0');
            themeToggleCircle.classList.add('translate-x-7');
            sunIcon.classList.remove('opacity-100');
            sunIcon.classList.add('opacity-0');
            moonIcon.classList.remove('opacity-0');
            moonIcon.classList.add('opacity-100');
        } else {
            themeToggleCircle.classList.add('translate-x-0');
            themeToggleCircle.classList.remove('translate-x-7');
            sunIcon.classList.add('opacity-100');
            sunIcon.classList.remove('opacity-0');
            moonIcon.classList.add('opacity-0');
            moonIcon.classList.remove('opacity-100');
        }
    }
</script>