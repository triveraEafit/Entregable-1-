@php($c = $category)

<label>Nombre</label>
<input type="text" name="name" value="{{ old('name', $c->name ?? '') }}">
@error('name') <span class="error">{{ $message }}</span> @enderror

<label>Descripción</label>
<textarea name="description">{{ old('description', $c->description ?? '') }}</textarea>
