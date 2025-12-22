<div class="p-4 sm:p-8 bg-white shadow sm:rounded-2xl border border-gray-100">
    <div class="max-w-xl">
        <section>
            <header>
                <h2 class="text-lg font-medium text-gray-900">Objectif Quotidien</h2>
                <p class="mt-1 text-sm text-gray-600">Combien de nouveaux verbes veux-tu apprendre chaque jour ?</p>
            </header>

            <form method="post" action="{{ route('profile.update-target') }}" class="mt-6 space-y-6">
                @csrf @method('patch')
                <select name="daily_target"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm w-full">
                    <option value="5" {{ auth()->user()->daily_target == 5 ? 'selected' : '' }}>5 verbes (Tranquille)
                    </option>
                    <option value="10" {{ auth()->user()->daily_target == 10 ? 'selected' : '' }}>10 verbes (Sérieux)
                    </option>
                    <option value="15" {{ auth()->user()->daily_target == 15 ? 'selected' : '' }}>15 verbes (Guerrier)
                    </option>
                </select>
                <x-primary-button>Enregistrer l'objectif</x-primary-button>
            </form>
        </section>
    </div>
</div>