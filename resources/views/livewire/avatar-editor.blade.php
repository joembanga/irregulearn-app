<div class="bg-surface rounded-3xl shadow-2xl overflow-hidden border border-muted">
    <div class="flex flex-col lg:flex-row">
        <div
            class="lg:w-2/5 bg-surface p-8 flex flex-col items-center justify-center border-b lg:border-b-0 lg:border-r border-muted">
            <div class="sticky top-10 flex flex-col items-center">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-primary/10 rounded-full blur-2xl"></div>
                    <div class="relative w-56 h-56 sm:w-72 sm:h-72">
                        <img src="{{ $currentUrl }}" class="w-full h-full drop-shadow-2xl">
                        <div wire:loading
                            class="absolute inset-0 flex items-center justify-center bg-surface/40 rounded-full backdrop-blur-[2px]">
                            <div
                                class="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button wire:click="generateRandom"
                        class="px-6 py-2 bg-surface shadow-sm border border-muted rounded-full text-xs font-bold uppercase tracking-widest hover:bg-primary-10 transition">
                        🎲 Aléatoire
                    </button>
                    <button wire:click="save"
                        class="px-6 py-2 bg-primary text-surface rounded-full text-xs font-bold uppercase tracking-widest hover:opacity-95 shadow-lg shadow-primary/20 transition">
                        💾 Sauver
                    </button>
                </div>
            </div>
        </div>

        <div class="lg:w-3/5 p-6 sm:p-10 max-h-[700px] overflow-y-auto fancy-scroll" x-data="{ tab: 'visage' }">

            <div class="flex gap-2 mb-10 overflow-x-auto pb-2 no-scrollbar">
                <button @click="tab = 'visage'"
                    :class="tab === 'visage' ? 'bg-primary text-surface' : 'bg-surface text-muted'"
                    class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition">Visage & Peau</button>
                <button @click="tab = 'cheveux'"
                    :class="tab === 'cheveux' ? 'bg-primary text-surface' : 'bg-surface text-muted'"
                    class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition">Coiffure</button>
                <button @click="tab = 'vetements'"
                    :class="tab === 'vetements' ? 'bg-primary text-surface' : 'bg-surface text-muted'"
                    class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition">Style</button>
            </div>

            <div class="space-y-12">

                <div x-show="tab === 'visage'" class="space-y-10">
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