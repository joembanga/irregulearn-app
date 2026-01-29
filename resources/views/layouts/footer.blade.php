<footer class="relative mt-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto px-6 py-8 flex md:flex-row justify-between items-center gap-4">

        <nav class="flex flex-col md:flex-row gap-3 text-sm text-muted list-none">
            <ul class="flex flex-col md:flex-row gap-3">
                <li>
                    <a href="#" wire:navigate class="text-muted hover:text-primary transition-colors font-medium">{{ __('Confidentialité') }}</a>
                </li>
                <li>
                    <a href="#" wire:navigate class="text-muted hover:text-primary transition-colors font-medium">{{ __('À propos') }}</a>
                </li>
            </ul>
            <div class="hidden md:block">•</div>
            <p class="font-medium">© {{ date('Y') }} IrreguLearn</p>
        </nav>
        <livewire:toggle-lang-button />
    </div>
</footer>