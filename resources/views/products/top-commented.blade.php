@extends('layouts.app')

@section('title', 'Top comentados')

@section('content')
    <h1>Productos más comentados</h1>

    <ol>
        @foreach ($viewData['products'] as $product)
            <li>
                <a href="{{ route('products.show', $product->getId()) }}">{{ $product->getName() }}</a>
                — {{ $product->getReviewsCount() }} comentarios
            </li>
        @endforeach
    </ol>
@endsection