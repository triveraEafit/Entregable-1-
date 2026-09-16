@php($b = $brand)

<label>{{ __('brands.name') }}</label>
<input type="text" name="name" value="{{ old('name', $b?->getName() ?? '') }}">
@error('name') <span class="error">{{ $message }}</span> @enderror

<label>{{ __('brands.country') }}</label>
<input type="text" name="country" value="{{ old('country', $b?->getCountry() ?? '') }}">
@error('country') <span class="error">{{ $message }}</span> @enderror

<label>{{ __('brands.website') }}</label>
<input type="text" name="website" value="{{ old('website', $b?->getWebsite() ?? '') }}">
@error('website') <span class="error">{{ $message }}</span> @enderror