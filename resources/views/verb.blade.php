<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="font-semibold text-xl text-body leading-tight">{{ $verb->infinitive }}</h1>
            <div class="hidden sm:flex items-center gap-3">
                <a href="{{ route('learn') }}" class="px-3 py-2 bg-primary text-surface rounded-lg">Pratiquer</a>
                <button class="px-3 py-2 bg-accent text-surface rounded-lg">Ajouter aux favoris</button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-6">
            <div class="card-surface rounded-2xl p-6 shadow-lg border border-muted">
                <div class="flex flex-col md:flex-row md:items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-2.5 h-28 rounded-md bg-primary"></div>
                        <div>
                            <h2 class="text-3xl font-extrabold text-body">{{ $verb->infinitive }}
                            </h2>
                            <p class="mt-1 text-sm text-muted italic">Exemple: "I
                                <strong>{{ $verb->past_simple }}</strong> to the market yesterday."
                            </p>
                        </div>
                    </div>

                    <div class="ms-auto flex flex-col gap-3">
                        <div class="ms-auto flex gap-3">
                            <div class="px-4 py-2 bg-primary-10 text-primary rounded-lg font-mono font-bold">
                                {{ str_replace('/', ' or ', $verb->past_simple) }}
                            </div>
                            <div class="px-4 py-2 bg-success-10 text-success rounded-lg font-mono font-bold">
                                {{ str_replace('/', ' or ', $verb->past_participle) }}
                            </div>
                        </div>
                        <livewire:add-to-favs-button :$verb/>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-lg bg-surface">
                        <h4 class="font-semibold text-body mb-2">Conjugaison</h4>
                        <pre class="font-mono text-sm text-muted">{{ $verb->conjugation ?? '—' }}
                        </pre>
                    </div>
                    <div class="p-4 rounded-lg bg-surface">
                        <h4 class="font-semibold text-body mb-2">Notes</h4>
                        <p class="text-sm text-muted">{{ $verb->notes ?? 'Aucune note.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>