<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ $verb->exists ? 'Edit Verb: ' . $verb->infinitive : 'Add New Verb' }}
        </h2>
        <a href="{{ route('admin.verbs.index') }}" wire.navigate class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 transition-colors">
            Cancel
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-soft border border-gray-100 dark:border-gray-700 p-6">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Infinitive -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Infinitive</label>
                    <input wire:model="verb.infinitive" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-primary focus:border-primary">
                    @error('verb.infinitive') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Translation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Translation (FR)</label>
                    <input wire:model="verb.translation" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-primary focus:border-primary">
                    @error('verb.translation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Past Simple -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Past Simple</label>
                    <input wire:model="verb.past_simple" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-primary focus:border-primary">
                    @error('verb.past_simple') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Past Participle -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Past Participle</label>
                    <input wire:model="verb.past_participle" type="text" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-primary focus:border-primary">
                    @error('verb.past_participle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description / Definition</label>
                    <textarea wire:model="verb.description" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-primary focus:border-primary"></textarea>
                    @error('verb.description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Level -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Level</label>
                    <select wire:model="verb.level" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-primary focus:border-primary">
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                    @error('verb.level') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Categories -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Categories</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($categories as $category)
                    <label class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                        <input type="checkbox" wire:model="selectedCategories" value="{{ $category->id }}" class="rounded text-primary focus:ring-primary border-gray-300 dark:border-gray-600">
                        <span class="text-sm text-gray-700 dark:text-gray-200">{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" class="px-6 py-2 bg-primary text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors shadow-lg shadow-purple-500/30">
                    {{ $verb->exists ? 'Update Verb' : 'Create Verb' }}
                </button>
            </div>
        </form>
    </div>
</div>