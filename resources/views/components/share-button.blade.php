@props([
    'title' => 'IrreguLearn',
    'text' => 'Apprend les verbes irréguliers sur IrreguLearn !',
    'url' => url()->current(),
    'class' => ''
])

<div x-data="{ 
    copied: false,
    share() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $title }}',
                text: '{{ $text }}',
                url: '{{ $url }}'
            }).catch(console.error);
        } else {
            navigator.clipboard.writeText('{{ $url }}');
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
    }
}" class="{{ $class }}">
    <button @click="share" {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 px-6 py-2 bg-surface border border-muted text-body rounded-2xl font-bold text-sm hover:bg-muted/5 transition active:scale-95 shadow-sm']) }}>
        <slot>
            <span x-show="!copied">🔗 Partager</span>
            <span x-show="copied" x-cloak class="text-success">✅ Lien copié !</span>
        </slot>
    </button>
    {{-- <button x-data="{ copied: false }"
        @click="navigator.clipboard.writeText('{{ route('share.image', ['type' => 'stats', 'identifier' => $user->username]) }}'); copied = true; setTimeout(() => copied = false, 2000)"
        class="inline-flex items-center gap-2 mt-6 px-6 py-2 bg-primary/10 border border-primary/20 text-primary rounded-2xl font-bold text-sm hover:bg-primary/20 transition active:scale-95 shadow-sm">
        <span x-show="!copied">🏆 Partager mon Trophée</span>
        <span x-show="copied" x-cloak class="text-success">✅ Lien image copié !</span>
    </button> --}}
</div>
