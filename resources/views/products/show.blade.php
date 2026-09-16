@extends('layouts.app')

@section('title', $viewData['product']->getName())

@section('content')
    <h1>{{ $viewData['product']->getName() }}</h1>
    <p>{{ $viewData['product']->getDescription() }}</p>
    <p>{{ $viewData['product']->getFormattedPrice() }} — {{ $viewData['product']->brand->getName() }} / {{ $viewData['product']->category->getName() }}</p>
    <p>Calificación promedio: {{ $viewData['product']->averageRating() }} / 5</p>

    @auth
        <form action="{{ route('orders.checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="items[0][product_id]" value="{{ $viewData['product']->getId() }}">
            <label>Cantidad</label>
            <input type="number" name="items[0][quantity]" value="1" min="1">
            <button type="submit" @disabled(! $viewData['product']->checkAvailability())>Comprar</button>
        </form>

        <h2>Dejar una reseña</h2>
        <form action="{{ route('reviews.store', $viewData['product']->getId()) }}" method="POST">
            @csrf
            <label>Calificación (1-5)</label>
            <input type="number" name="rating" min="1" max="5">
            <label>Comentario</label>
            <textarea name="comment"></textarea>
            <button type="submit">Enviar reseña</button>
        </form>
    @endauth

    <h2>Reseñas ({{ $viewData['product']->reviews->count() }})</h2>
    @forelse ($viewData['product']->reviews->sortByDesc(fn ($review) => $review->getCreatedAtReview()) as $review)
        <div class="review">
            <strong>{{ $review->user->getName() }}</strong>
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