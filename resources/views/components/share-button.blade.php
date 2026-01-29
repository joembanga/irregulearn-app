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
    <button @click="share" {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 p-2 bg-surface border border-muted text-body rounded-xl font-bold text-sm transition active:scale-95']) }}>
        <slot>
            <span x-show="!copied"><x-lucide-share class="size-5 stroke-current" /></span>
            <span x-show="copied" x-cloak><x-lucide-copy-check class="size-5 stroke-current" /></span>
        </slot>
    </button>
</div>
