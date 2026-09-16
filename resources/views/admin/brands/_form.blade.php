@php($b = $brand)

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('brands.name') }}</label>
    <input type="text" name="name" value="{{ old('name', $b?->getName() ?? '') }}"
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500">
    @error('name')
        <span class="text-red-600 text-sm">{{ $message }}</span>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('brands.country') }}</label>
    <input type="text" name="country" value="{{ old('country', $b?->getCountry() ?? '') }}"
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500">
    @error('country')
        <span class="text-red-600 text-sm">{{ $message }}</span>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('brands.website') }}</label>
    <input type="text" name="website" value="{{ old('website', $b?->getWebsite() ?? '') }}"
        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-500">
    @error('website')
        <span class="text-red-600 text-sm">{{ $message }}</span>
    @enderror
</div>