@extends('layouts.app')

@section('title', 'Top comentados')

@section('content')
    <h1>Productos más comentados</h1>

    <ol>
        @foreach ($products as $product)
            <li>
                <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                — {{ $product->reviews_count }} comentarios
            </li>
        @endforeach
    </ol>
@endsection
