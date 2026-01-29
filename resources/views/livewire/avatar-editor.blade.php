<section>
    <header class="pb-4">
        <h2 class="text-xl font-medium text-body">
            {{ __('Customises ton avatar') }}
        </h2>
    
        <p class="mt-1 text-sm text-muted">
            {{ __('Crée un avatar qui te ressemble (ou pas du tout).') }}
        </p>
    </header>
    <div class="bg-surface shadow-md overflow-hidden border border-muted">
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-2/5 bg-surface p-8 flex flex-col items-center justify-center border-b lg:border-b-0 lg:border-r border-muted">
                <div class="sticky top-10 flex flex-col items-center">
                    <div class="relative group">
                        <div class="relative w-56 h-56 sm:w-72 sm:h-72">
                            <img src="{{ $currentUrl }}" class="w-full h-full drop-shadow-xl">
                            <div wire:loading
                                class="absolute inset-0 flex items-center justify-center bg-surface/40 rounded-full backdrop-blur-[2px]">
                                <div class="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>
                    </div>
    
                    <div class="mt-8 flex flex-col md:flex-row gap-4">
                        <button wire:click="generateRandom"
                            class="flex items-center justify-center gap-2 px-6 py-3 bg-surface shadow-sm border border-muted rounded-full text-sm font-bold uppercase tracking-widest hover:bg-primary-10 transition">
                            <x-lucide-dices class="size-5" />
                            <span>{{ __('Aléatoire')}}</span>
                        </button>
                        <button wire:click="save"
                            class="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-surface rounded-full text-sm font-bold uppercase tracking-widest hover:opacity-95 transition">
                            <x-lucide-save class="size-5 inline" />
                            <span>{{ __('Enregistrer') }}</span>
                        </button>
                    </div>
                </div>
            </div>
    
            <div class="lg:w-3/5 p-4 sm:p-8 max-h-175 overflow-y-auto fancy-scroll" x-data="{ tab: 'visage' }">
    
                <div class="flex gap-2 mb-10 overflow-x-auto pb-2 no-scrollbar">
                    <button @click="tab = 'visage'"
                        :class="tab === 'visage' ? 'bg-primary text-surface' : 'bg-surface text-muted'"
                        class="px-4 py-2 rounded-full text-sm border border-muted font-bold whitespace-nowrap transition">{{ __('Visage & Peau') }}</button>
                    <button @click="tab = 'cheveux'"
                        :class="tab === 'cheveux' ? 'bg-primary text-surface' : 'bg-surface text-muted'"
                        class="px-4 py-2 rounded-full text-sm font-bold whitespace-nowrap transition">{{ __('Coiffure') }}</button>
                    <button @click="tab = 'vetements'"
                        :class="tab === 'vetements' ? 'bg-primary text-surface' : 'bg-surface text-muted'"
                        class="px-4 py-2 rounded-full text-sm font-bold whitespace-nowrap transition">{{ __('Style') }}</button>
                </div>

                <div class="space-y-8">

                    <div x-show="tab === 'visage'" class="space-y-6">
                        @foreach(['skinColor', 'eyeType', 'eyebrowType', 'mouthType'] as $trait)
                        <div wire:key="visage-{{ $trait }}">
                            @include('partials.avatar-trait-group', ['trait' => $trait])
                        </div>
                        @endforeach
                    </div>
    
                    <div x-show="tab === 'cheveux'" class="space-y-10">
                        @foreach(['topType', 'hairColor', 'hatColor', 'facialHairType', 'facialHairColor'] as $trait)
                        <div wire:key="cheveux-{{ $trait }}">
                            @include('partials.avatar-trait-group', ['trait' => $trait])
                        </div>
                        @endforeach
                    </div>
    
                    <div x-show="tab === 'vetements'" class="space-y-10">
                        @foreach(['clotheType', 'clotheColor', 'graphicType', 'accessoriesType'] as $trait)
                        <div wire:key="vetements-{{ $trait }}">
                            @include('partials.avatar-trait-group', ['trait' => $trait])
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>