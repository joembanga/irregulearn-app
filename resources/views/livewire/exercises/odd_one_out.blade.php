<div class="text-center animate-fade-in">
    <h2 class="text-2xl font-black text-body mb-8">
        Touve l'intrus
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach($choices as $choice)
        <button wire:key="odd-{{ $currentVerb->id }}-{{ $currentIndex }}" wire:click="checkAnswer('{{ $choice }}')"
            class="p-6 rounded-2xl font-bold text-lg transition-all border-2 bg-surface hover:border-primary">
            {{ \Illuminate\Support\Str::title($choice) }}
        </button>
        @endforeach
    </div>
</div>