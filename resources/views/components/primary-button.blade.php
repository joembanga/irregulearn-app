<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-primary text-surface border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
