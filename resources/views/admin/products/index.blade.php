@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
    <h1>Productos</h1>
    <a href="{{ route('admin.products.create') }}">+ Nuevo producto</a>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->brand->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->formatted_price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->active ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}">Editar</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Desactivar este producto?')">Desactivar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
@endsection
