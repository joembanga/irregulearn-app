<div class="mt-10">
    <h3 class="text-2xl font-bold text-body mb-6">{{ __('Communauté')}}</h3>

    <div class="card-surface p-4 rounded-2xl mb-8 border-muted">
        <textarea wire:model="body" placeholder="{{ __('Écris un exemple original pour ce verbe...') }}"
            class="w-full bg-transparent border-none focus:ring-0 text-body placeholder:text-muted resize-none"
            rows="2"></textarea>
        <div class="flex justify-between items-center mt-2 pt-2 border-t border-muted">
            <span class="text-xs text-muted">{{ __('Gagne +10 XP en aidant les autres')}}</span>
            <button wire:click="submitExample"
                class="px-4 py-1.5 bg-primary text-white text-sm font-bold rounded-full transition-transform active:scale-95">
                {{ __('Publier') }}
            </button>
        </div>
    </div>

    <div class="space-y-4">
        @foreach($examples as $example)
        @php
            $author = \App\Models\User::where('id', $example->user_id)->first();
        @endphp
        <div class="flex gap-4 p-4 rounded-2xl bg-surface border border-muted group">
            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-muted font-black truncate">
                <x-user-avatar :user="$author"/>
            </div>
            <div class="flex-1">
                <div class="flex justify-between items-start">
                    <span class="text-xs font-bold text-primary">{{ $author->username }}</span>
                    <span class="text-[10px] text-muted">{{ $example->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-sm text-body mt-1 italic">"{{ $example->body }}"</p>
                <div class="flex items-center justify-between">
                    @php $alreadyLiked = auth()->user()->hasLikedExample($example); @endphp
                    <button wire:click="like({{ $example->id }})"
                        class="mt-3 flex items-center gap-1.5 transition-all {{ $alreadyLiked ? 'text-primary scale-110' : 'text-muted' }}">
                    
                        <span class="text-xs font-bold">{{ $example->likes_count }}</span>
                    
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                            fill="{{ $alreadyLiked ? 'currentColor' : 'none' }}" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="text-muted hover:text-body text-xs font-bold">•••</button>
                    
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 card-surface shadow-xl rounded-xl z-50 py-2 border-muted">
                            <button wire:click="report({{ $example->id }})" @click="open = false"
                                class="w-full text-left px-4 py-2 text-xs text-danger font-bold hover:bg-danger/10">
                                Signaler cet exemple
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>