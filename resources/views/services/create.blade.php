<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('services.index') }}" class="text-gray-500 hover:text-indigo-600 transition-colors font-medium text-sm">
                &larr; Back
            </a>
            <h2 class="font-bold text-2xl salon-text-gradient leading-tight tracking-tight">
                Add New Service
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="salon-form-container">
                <form action="{{ route('services.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <div class="space-y-1">
                        <x-input-label for="name" value="Service Name" class="salon-label" />
                        <x-text-input id="name" name="name" type="text" 
                            class="salon-input block w-full"
                            value="{{ old('name') }}" required placeholder="e.g. Deluxe Haircut" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div class="space-y-1">
                        <x-input-label for="description" value="Description" class="salon-label" />
                        <textarea id="description" name="description" rows="4"
                            class="salon-input block w-full resize-none"
                            placeholder="Provide details about the service...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1 relative">
                            <x-input-label for="price" value="Price (PHP)" class="salon-label" />
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 font-semibold">&#8369;</span>
                                <x-text-input id="price" name="price" type="number" step="0.01" min="0"
                                    class="salon-input block w-full pl-8" 
                                    value="{{ old('price') }}" required placeholder="0.00" />
                            </div>
                            <x-input-error :messages="$errors->get('price')" class="mt-1" />
                        </div>
                        <div class="space-y-1">
                            <x-input-label for="duration_minutes" value="Duration (minutes)" class="salon-label" />
                            <div class="relative">
                                <x-text-input id="duration_minutes" name="duration_minutes" type="number" min="1"
                                    class="salon-input block w-full pr-16" 
                                    value="{{ old('duration_minutes') }}" required placeholder="60" />
                                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 text-sm">min</span>
                            </div>
                            <x-input-error :messages="$errors->get('duration_minutes')" class="mt-1" />
                        </div>
                    </div>

                    <div class="pt-4 pb-2">
                        <label for="is_active" class="salon-toggle-label p-4 w-full md:w-auto group">
                            <div class="relative flex items-center justify-center">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                    class="salon-toggle-input peer sr-only"
                                    {{ old('_token') ? (old('is_active') ? 'checked' : '') : 'checked' }}>
                                <div class="salon-toggle-track"></div>
                                <div class="salon-toggle-thumb"></div>
                            </div>
                            <span class="ml-3 font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-700 dark:group-hover:text-indigo-400 transition-colors">Service is Active</span>
                        </label>
                    </div>

                    <div class="salon-form-actions">
                        <button type="submit" class="salon-btn-primary px-6 py-3">
                            Save Service
                        </button>
                        <a href="{{ route('services.index') }}" class="salon-btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
