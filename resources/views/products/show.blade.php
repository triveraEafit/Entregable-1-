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

    <h2>Reseñas ({{ $product->reviews->count() }})</h2>
    @forelse ($product->reviews->sortByDesc(fn ($review) => $review->getCreatedAtReview()) as $review)
        <div class="review">
            <strong>{{ $review->user->name }}</strong>
            <span>{{ str_repeat('★', $review->getRating()) }}{{ str_repeat('☆', 5 - $review->getRating()) }}</span>
            <time>{{ \Illuminate\Support\Carbon::parse($review->getCreatedAtReview())->format('d/m/Y') }}</time>
            @if ($review->getComment())
                <p>{{ $review->getComment() }}</p>
            @endif
        </div>
    @empty
        <p>Aún no hay reseñas todavía. ¡Sé el primero en dejar una!</p>
    @endforelse
@endsection
