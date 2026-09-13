@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <h1>{{ $product->name }}</h1>
    <p>{{ $product->description }}</p>
    <p>{{ $product->formatted_price }} — {{ $product->brand->name }} / {{ $product->category->name }}</p>
    <p>Calificación promedio: {{ $product->averageRating() }} / 5</p>

    @auth
        <form action="{{ route('orders.checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="items[0][product_id]" value="{{ $product->id }}">
            <label>Cantidad</label>
            <input type="number" name="items[0][quantity]" value="1" min="1">
            <button type="submit" @disabled(! $product->checkAvailability())>Comprar</button>
        </form>

        <h2>Dejar una reseña</h2>
        <form action="{{ route('reviews.store', $product) }}" method="POST">
            @csrf
            <label>Calificación (1-5)</label>
            <input type="number" name="rating" min="1" max="5">
            <label>Comentario</label>
            <textarea name="comment"></textarea>
            <button type="submit">Enviar reseña</button>
        </form>
    @endauth

    <h2>Reseñas</h2>
    @forelse ($product->reviews as $review)
        <div class="review">
            <strong>{{ $review->user->name }}</strong> — {{ $review->rating }}/5
            <p>{{ $review->comment }}</p>
        </div>
    @empty
        <p>Aún no hay reseñas.</p>
    @endforelse
@endsection
