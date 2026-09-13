@extends('layouts.admin')

@section('title', 'Categorías')

@section('content')
    <h1>Categorías</h1>
    <a href="{{ route('admin.categories.create') }}">+ Nueva categoría</a>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th># Productos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}">Editar</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}
@endsection
