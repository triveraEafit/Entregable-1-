@php($p = $product)

<label>Nombre</label>
<input type="text" name="name" value="{{ old('name', $p->name ?? '') }}">
@error('name') <span class="error">{{ $message }}</span> @enderror

<label>Descripción</label>
<textarea name="description">{{ old('description', $p->description ?? '') }}</textarea>

<label>Precio</label>
<input type="number" step="0.01" name="price" value="{{ old('price', $p->price ?? '') }}">
@error('price') <span class="error">{{ $message }}</span> @enderror

<label>Stock</label>
<input type="number" name="stock" value="{{ old('stock', $p->stock ?? 0) }}">
@error('stock') <span class="error">{{ $message }}</span> @enderror

<label>Imagen</label>
<input type="file" name="image">
@error('image') <span class="error">{{ $message }}</span> @enderror

<label>Marca</label>
<select name="brand_id">
    @foreach ($brands as $brand)
        <option value="{{ $brand->id }}" @selected(old('brand_id', $p->brand_id ?? null) == $brand->id)>
            {{ $brand->name }}
        </option>
    @endforeach
</select>

<label>Categoría</label>
<select name="category_id">
    @foreach ($categories as $category)
        <option value="{{ $category->id }}" @selected(old('category_id', $p->category_id ?? null) == $category->id)>
            {{ $category->name }}
        </option>
    @endforeach
</select>

<label>
    <input type="checkbox" name="active" value="1" @checked(old('active', $p->active ?? true))>
    Activo
</label>
