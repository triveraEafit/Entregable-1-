@php($c = $category)

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('categories.name') }}</label>
    <input type="text" name="name" value="{{ old('name', $c?->getName() ?? '') }}"
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500">
    @error('name')
        <span class="text-red-600 text-sm">{{ $message }}</span>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('categories.description') }}</label>
    <textarea name="description" rows="3"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500">{{ old('description', $c?->getDescription() ?? '') }}</textarea>
</div>