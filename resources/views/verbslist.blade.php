<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 dark:text-gray-200 transition-colors duration-300">
        <div class="max-w-5xl mx-auto px-6">

            <div class="flex flex-col md:flex-row justify-between gap-4 mb-8">
                <div class="flex gap-2 bg-gray-200 p-1 rounded-3xl">
                    <a href="{{ route('verbslist', ['level' => 'beginner']) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $filter === 'beginner' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500' }}">
                        Beginner</a>
                    <a href="{{ route('verbslist', ['level' => 'intermediate']) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $filter === 'intermediate' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500' }}">
                        Intermediate</a>
                    <a href="{{ route('verbslist', ['level' => 'expert']) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $filter === 'expert' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500' }}">
                        Expert</a>
                    <a href="{{ route('verbslist', ['level' => 'all']) }}"
                        class="px-4 py-2 rounded-xl text-sm font-bold {{ $filter === 'all' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500' }}">
                        All</a>
                </div>
            </div>

            <div
                class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100 dark:bg-gray-900 dark:text-gray-200 transition-colors duration-300">
                <table class="w-full text-left">
                    <thead class="bg-gray-900 text-white">
                        <tr>
                            <th class="px-6 py-4 text-xs uppercase"></th>
                            <th class="px-6 py-4 text-xs uppercase">Infinitive</th>
                            <th class="px-6 py-4 text-xs uppercase">Past Simple</th>
                            <th class="px-6 py-4 text-xs uppercase">Past Participle</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($verbs as $index => $verb)
                        <tr>
                            <td class="px-6 py-5 font-black text-gray-400">
                                #{{ $verbs->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-5">
                                <a href="{{ route('verb', $verb->slug) }}"
                                    class="flex items-center gap-3 group">
                                    <span class="font-bold text-gray-800 group-hover:text-indigo-600 transition">
                                        {{ $verb->infinitive }}
                                    </span>
                                </a>
                            </td>
                            <td class="px-6 py-5 text-left font-mono font-bold">
                                <span
                                    class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg text-sm">{{ str_replace('/', " or ",$verb->past_simple) }}</span>
                            </td>
                            <td class="px-6 py-5 text-left font-mono font-bold">
                                <span
                                    class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-lg text-sm">{{ str_replace('/', " or ", $verb->past_participle) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-6">
                    {{ $verbs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>