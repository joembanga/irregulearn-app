<x-app-layout>
    <div class="py-8 bg-app min-h-screen" x-data="{ selectedVerbs: [], selectAll: false }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">

            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('learn.index') }}" wire:navigate
                    class="inline-flex items-center gap-2 text-muted hover:text-primary transition-colors mb-4">
                    <span>←</span>
                    <span class="font-bold">{{ __('Retour aux modes') }}</span>
                </a>

                <h1 class="text-4xl font-bold text-body mb-3">{{ __('Pratique Ciblée') }}</h1>
                <p class="text-lg text-muted">{{ __('Sélectionne les verbes que tu veux pratiquer') }}</p>
            </div>

            <!-- Selected Count & Actions -->
            <div
                class="sticky top-24 z-30 bg-surface/95 backdrop-blur-lg rounded-2xl border border-muted p-4 mb-6 shadow-lg">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="text-sm">
                            <span class="font-bold text-primary text-2xl" x-text="selectedVerbs.length"></span>
                            <span class="text-muted font-bold">{{ __('verbes sélectionnés') }}</span>
                        </div>
                        <button
                            @click="selectAll = !selectAll; selectedVerbs = selectAll ? $refs.verbsList.querySelectorAll('input[type=checkbox]').forEach(cb => { if(!cb.disabled) { cb.checked = true; selectedVerbs.push(parseInt(cb.value)); } }) : []"
                            class="text-xs font-bold text-primary hover:underline">
                            <span x-show="!selectAll">{{ __('Tout sélectionner') }}</span>
                            <span x-show="selectAll">{{ __('Tout désélectionner') }}</span>
                        </button>
                    </div>

                    <template x-if="selectedVerbs.length >= 5">
                        <form action="{{ route('learn.session') }}" method="GET"
                            x-on:submit="$event.target.querySelector('input[name=verbs]').value = selectedVerbs.join(',')">
                            <input type="hidden" name="mode" value="custom">
                            <input type="hidden" name="verbs" value="">
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-white rounded-xl font-bold shadow-lg transition-all">
                                <span>{{ __('Démarrer la Session') }}</span>
                                <span>→</span>
                            </button>
                        </form>
                    </template>
                    <template x-if="selectedVerbs.length < 5">
                        <div class="text-sm text-muted font-bold">
                            {{ __('Sélectionne au moins 5 verbes') }}
                        </div>
                    </template>
                </div>
            </div>

            <!-- Categories with Verbs -->
            <div class="space-y-6" x-ref="verbsList">
                @foreach($categories as $category)
                <div class="bg-surface rounded-2xl border border-muted overflow-hidden">
                    <div class="bg-linear-to-r from-primary/10 to-primary/5 px-6 py-4 border-b border-muted">
                        <h3 class="text-xl font-bold text-body">{{ $category->name }}</h3>
                        <p class="text-sm text-muted mt-1">{{ $category->verbs->count() }} {{ __('verbes') }}</p>
                    </div>

                    <div class="p-6">
                        <div class="grid gap-3">
                            @foreach($category->verbs as $verb)
                            <label
                                class="flex items-center gap-4 p-4 rounded-xl border border-muted hover:border-primary/30 hover:bg-primary/5 transition-all cursor-pointer group">
                                <input type="checkbox" value="{{ $verb->id }}" x-model="selectedVerbs"
                                    class="w-5 h-5 rounded border-muted text-primary focus:ring-primary focus:ring-2">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <span
                                            class="font-bold text-body group-hover:text-primary transition-colors">{{ $verb->infinitive }}</span>
                                        <span class="text-sm text-muted">→</span>
                                        <span class="text-sm font-bold text-muted">{{ $verb->past_simple }}</span>
                                        <span class="text-sm text-muted">→</span>
                                        <span class="text-sm font-bold text-muted">{{ $verb->past_participle }}</span>
                                    </div>
                                    @if($verb->translation_fr)
                                    <p class="text-xs text-muted mt-1 italic">{{ $verb->translation_fr }}</p>
                                    @endif
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>