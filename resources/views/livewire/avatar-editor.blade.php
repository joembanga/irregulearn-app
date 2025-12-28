<div
    class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
    <div class="flex flex-col lg:flex-row">
        <div
            class="lg:w-2/5 bg-slate-50 dark:bg-gray-900/50 p-8 flex flex-col items-center justify-center border-b lg:border-b-0 lg:border-r border-gray-100 dark:border-gray-700">
            <div class="sticky top-10 flex flex-col items-center">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-indigo-500/10 rounded-full blur-2xl"></div>
                    <div class="relative w-56 h-56 sm:w-72 sm:h-72">
                        <img src="{{ $currentUrl }}" class="w-full h-full drop-shadow-2xl">
                        <div wire:loading
                            class="absolute inset-0 flex items-center justify-center bg-white/40 dark:bg-black/40 rounded-full backdrop-blur-[2px]">
                            <div
                                class="w-12 h-12 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button wire:click="generateRandom"
                        class="px-6 py-2 bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-full text-xs font-black uppercase tracking-widest hover:bg-gray-50 transition">
                        🎲 Aléatoire
                    </button>
                    <button wire:click="save"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-full text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 dark:shadow-none transition">
                        💾 Sauver
                    </button>
                </div>
            </div>
        </div>

        <div class="lg:w-3/5 p-6 sm:p-10 max-h-[700px] overflow-y-auto custom-scrollbar" x-data="{ tab: 'visage' }">

            <div class="flex gap-2 mb-10 overflow-x-auto pb-2 no-scrollbar">
                <button @click="tab = 'visage'"
                    :class="tab === 'visage' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-500'"
                    class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition">Visage & Peau</button>
                <button @click="tab = 'cheveux'"
                    :class="tab === 'cheveux' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-500'"
                    class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition">Coiffure</button>
                <button @click="tab = 'vetements'"
                    :class="tab === 'vetements' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-500'"
                    class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition">Style</button>
            </div>

            <div class="space-y-12">

                <div x-show="tab === 'visage'" class="space-y-10">
                    @foreach(['skinColor', 'eyeType', 'eyebrowType', 'mouthType'] as $trait)
                    @include('partials.avatar-trait-group', ['trait' => $trait])
                    @endforeach
                </div>

                <div x-show="tab === 'cheveux'" class="space-y-10">
                    @foreach(['topType', 'hairColor', 'hatColor', 'facialHairType', 'facialHairColor'] as $trait)
                    @include('partials.avatar-trait-group', ['trait' => $trait])
                    @endforeach
                </div>

                <div x-show="tab === 'vetements'" class="space-y-10">
                    @foreach(['clotheType', 'clotheColor', 'graphicType', 'accessoriesType'] as $trait)
                    @include('partials.avatar-trait-group', ['trait' => $trait])
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>