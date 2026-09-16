@php($c = $category)

<label>{{ __('categories.name') }}</label>
<input type="text" name="name" value="{{ old('name', $c?->getName() ?? '') }}">
@error('name') <span class="error">{{ $message }}</span> @enderror

<label>{{ __('categories.description') }}</label>
<textarea name="description">{{ old('description', $c?->getDescription() ?? '') }}</textarea>