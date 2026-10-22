@props(['name', 'question', 'options' => ['baik', 'cukup', 'kurang']])

<div class="mb-8 pb-4 border-b border-gray-200 dark:border-gray-700">
    <h3 class="text-lg font-bold mb-4">{{ $question }}</h3>

    <div class="space-y-2">
        @foreach ($options as $value)
            <label class="flex items-center">
                <input type="radio" 
                       name="{{ $name }}" 
                       value="{{ $value }}" 
                       required 
                       class="form-radio text-indigo-600 dark:text-indigo-400"
                       {{ old($name) == $value ? 'checked' : '' }}>
                
                <span class="ms-2">{{ Str::ucfirst(str_replace('_', ' ', $value)) }}</span>
            </label>
        @endforeach
    </div>

    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>