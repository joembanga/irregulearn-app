<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-primary text-surface border border-transparent rounded-2xl font-bold text-sm hover:opacity-90 hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-200 shadow-sm shadow-primary/20']) }}>
    {{ $slot }}
</button>
