@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Productos</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-700 transition">
            + Nuevo producto
        </a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Nombre</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Marca</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Categoría</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Precio</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Stock</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Activo</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($products as $product)
                    <tr>
                        <td class="px-4 py-3">{{ $product->name }}</td>
                        <td class="px-4 py-3">{{ $product->brand->name }}</td>
                        <td class="px-4 py-3">{{ $product->category->name }}</td>
                        <td class="px-4 py-3">{{ $product->formatted_price }}</td>
                        <td class="px-4 py-3">{{ $product->stock }}</td>
                        <td class="px-4 py-3">
                            @if ($product->active)
                                <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded">Sí</span>
                            @else
                                <span class="inline-block bg-gray-100 text-gray-600 text-xs font-medium px-2 py-1 rounded">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="inline-block bg-amber-500 text-white px-3 py-1 rounded text-sm hover:bg-amber-600 transition">
                                Editar
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Desactivar este producto?')" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">
                                    Desactivar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endsection