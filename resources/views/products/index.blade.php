@extends('layouts.app')

@section('title', 'Catálogo')

@section('content')
    <h1>Catálogo de productos</h1>

    <form action="{{ route('products.search') }}" method="GET">
        <input type="text" name="q" placeholder="Buscar producto..." value="{{ $viewData['term'] ?? '' }}">
        <button type="submit">Buscar</button>
    </form>

    <form action="{{ route('products.filter') }}" method="GET">
        <label>Categoría</label>
        <select name="category_id">
            <option value="">Todas</option>
            @foreach ($viewData['categories'] ?? [] as $category)
                <option value="{{ $category->getId() }}" @selected(($viewData['selectedCategoryId'] ?? null) === $category->getId())>
                    {{ $category->getName() }}
                </option>
            @endforeach
        </select>

        <label>Marca</label>
        <select name="brand_id">
            <option value="">Todas</option>
            @foreach ($viewData['brands'] ?? [] as $brand)
                <option value="{{ $brand->getId() }}" @selected(($viewData['selectedBrandId'] ?? null) === $brand->getId())>
                    {{ $brand->getName() }}
                </option>
            @endforeach
        </select>

        <button type="submit">Filtrar</button>
    </form>

    <div class="grid">
        @forelse ($viewData['products'] as $product)
            <div class="card">
                <a href="{{ route('products.show', $product->getId()) }}">
                    <h3>{{ $product->getName() }}</h3>
                </a>
                <p>{{ $product->brand->getName() }} · {{ $product->category->getName() }}</p>
                <p>{{ $product->getFormattedPrice() }}</p>
                <p>{{ $product->checkAvailability() ? 'Disponible' : 'Agotado' }}</p>
            </div>
        @empty
            <p>No se encontraron productos.</p>
        @endforelse
    </div>

    {{ $viewData['products']->links() }}
@endsection