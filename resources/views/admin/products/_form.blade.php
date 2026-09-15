<label>{{ __('products.name') }}</label>
<input type="text" name="name" value="{{ old('name', $product?->getName() ?? '') }}">
@error('name') <span class="error">{{ $message }}</span> @enderror

<label>{{ __('products.description') }}</label>
<textarea name="description">{{ old('description', $product?->getDescription() ?? '') }}</textarea>
@error('description') <span class="error">{{ $message }}</span> @enderror

<label>{{ __('products.price') }}</label>
<input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product?->getPrice() ?? '') }}">
@error('price') <span class="error">{{ $message }}</span> @enderror

<label>{{ __('products.stock') }}</label>
<input type="number" min="0" name="stock" value="{{ old('stock', $product?->getStock() ?? 0) }}">
@error('stock') <span class="error">{{ $message }}</span> @enderror

<label>{{ __('products.image') }}</label>
@if ($product?->getImage())
    <img src="{{ asset('storage/'.$product->getImage()) }}" alt="{{ __('products.current_image') }}" width="120">
@endif
<input type="file" name="image" accept="image/jpeg,image/png,image/webp">
@error('image') <span class="error">{{ $message }}</span> @enderror

<label>{{ __('products.brand') }}</label>
<select name="brand_id">
    @foreach ($brands as $brand)
        <option value="{{ $brand->getId() }}" @selected(old('brand_id', $product?->getBrandId()) == $brand->getId())>
            {{ $brand->getName() }}
        </option>
    @endforeach
</select>
@error('brand_id') <span class="error">{{ $message }}</span> @enderror

<label>{{ __('products.category') }}</label>
<select name="category_id">
    @foreach ($categories as $category)
        <option value="{{ $category->getId() }}" @selected(old('category_id', $product?->getCategoryId()) == $category->getId())>
            {{ $category->getName() }}
        </option>
    @endforeach
</select>
@error('category_id') <span class="error">{{ $message }}</span> @enderror

<label>
    <input type="checkbox" name="active" value="1" @checked(old('active', $product?->getActive() ?? true))>
    {{ __('products.active') }}
</label>
