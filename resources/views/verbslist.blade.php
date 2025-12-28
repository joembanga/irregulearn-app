<x-app-layout>
    <div class="py-12 app-bg">
        <div class="max-w-5xl mx-auto px-6 flex flex-col gap-2">

            <div class="flex flex-row items-center justify-between gap-4 mb-8">
                <div class="flex gap-2 bg-gray-200 dark:bg-gray-800 p-1 rounded-3xl">
                    <a href="{{ route('verbslist', ['level' => 'beginner']) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $filter === 'beginner' ? 'bg-white dark:bg-primary/10 text-primary dark:text-primary/80 shadow-sm' : 'text-gray-700 dark:text-gray-300' }}">Beginner</a>
                    <a href="{{ route('verbslist', ['level' => 'intermediate']) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $filter === 'intermediate' ? 'bg-white dark:bg-primary/10 text-primary dark:text-primary/80 shadow-sm' : 'text-gray-700 dark:text-gray-300' }}">Intermediate</a>
                    <a href="{{ route('verbslist', ['level' => 'expert']) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $filter === 'expert' ? 'bg-white dark:bg-primary/10 text-primary dark:text-primary/80 shadow-sm' : 'text-gray-700 dark:text-gray-300' }}">Expert</a>
                    <a href="{{ route('verbslist', ['level' => 'all']) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $filter === 'all' ? 'bg-white dark:bg-primary/10 text-primary dark:text-primary/80 shadow-sm' : 'text-gray-700 dark:text-gray-300' }}">All</a>
                </div>
            </div>

            <div class="card-surface shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                <div class="hidden sm:block">
                    <table class="w-full text-left">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="px-6 py-4 text-xs uppercase"></th>
                                <th class="px-6 py-4 text-xs uppercase">Infinitive</th>
                                <th class="px-6 py-4 text-xs uppercase">Past Simple</th>
                                <th class="px-6 py-4 text-xs uppercase">Past Participle</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($verbs as $index => $verb)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-6 py-5 font-black text-gray-700">#{{ $verbs->firstItem() + $index }}</td>
                                <td class="px-6 py-5">
                                    <a href="{{ route('verb', $verb->slug) }}" class="flex items-center gap-3 group">
                                        <span
                                            class="font-bold text-gray-900 dark:text-white group-hover:text-primary transition">{{ $verb->infinitive }}</span>
                                    </a>
                                </td>
                                <td class="px-6 py-5 text-left font-mono font-bold"><span
                                        class="px-3 py-1 rounded-lg text-sm bg-primary/10 dark:bg-gray-800 text-primary dark:text-primary/80">{{ str_replace('/', ' or ', $verb->past_simple) }}</span>
                                </td>
                                <td class="px-6 py-5 text-left font-mono font-bold"><span
                                        class="px-3 py-1 rounded-lg text-sm bg-success/10 dark:bg-gray-800 text-success dark:text-success/70">{{ str_replace('/', ' or ', $verb->past_participle) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="sm:hidden p-4">
                    <div class="space-y-3">
                        @foreach($verbs as $index => $verb)
                        <a href="{{ route('verb', $verb->slug) }}"
                            class="block p-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $verb->infinitive }}</div>
                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ str_replace('/', ' or ', $verb->past_simple) }}
                                    </div>
                                </div>
                                <div class="text-sm font-mono text-gray-700 dark:text-gray-200">
                                    {{ str_replace('/', ' or ', $verb->past_participle) }}
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="p-6">{{ $verbs->links() }}</div>
            </div>
            <div class="flex flex-row-reverse justify-between items-center mt-8 mb-6">
                <a href="{{ route('verbs.export') }}"
                    class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-4 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 transition transform active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    TÉLÉCHARGER LA LISTE (.PDF)
                </a>
            </div>

        </div>
    </div>
</x-app-layout>