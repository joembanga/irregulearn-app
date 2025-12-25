<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            The verb to {{ \Illuminate\Support\Str::lower($verb->infinitive) }}
        </h1>
    </x-slot>

    <div class="space-y-6 mb-10">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-indigo-500"></div>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-black text-gray-800">{{ $verb->infinitive }}</h3>
                    <div class="mt-2 text-sm text-gray-600 italic">
                        "I <strong>{{ $verb->past_simple }}</strong> to the market yesterday."
                    </div>
                </div>
                <div class="flex gap-2">
                    <span
                        class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg font-mono font-bold text-sm">{{ $verb->past_simple }}</span>
                    <span
                        class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-lg font-mono font-bold text-sm">{{ str_replace('/', " or ", $verb->past_participle) }}</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>