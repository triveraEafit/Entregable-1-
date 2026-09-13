@extends('layouts.app')

@section('title', 'Catálogo')

@section('content')
    <h1>Catálogo de productos</h1>

    <form action="{{ route('products.search') }}" method="GET">
        <input type="text" name="q" placeholder="Buscar producto..." value="{{ $term ?? '' }}">
        <button type="submit">Buscar</button>
    </form>

    <div class="grid">
        @forelse ($products as $product)
            <div class="card">
                <a href="{{ route('products.show', $product->id) }}">
                    <h3>{{ $product->name }}</h3>
                </a>
                <p>{{ $product->brand->name }} · {{ $product->category->name }}</p>
                <p>{{ $product->formatted_price }}</p>
                <p>{{ $product->checkAvailability() ? 'Disponible' : 'Agotado' }}</p>
            </div>
        @empty
            <p>No se encontraron productos.</p>
        @endforelse
    </div>

    {{ $products->links() }}
@endsection
