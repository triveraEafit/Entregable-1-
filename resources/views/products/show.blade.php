@extends('layouts.app')

@section('title', $product->getName())

@section('content')
    <h1>{{ $product->getName() }}</h1>
    @if ($product->getImage())
        <img src="{{ asset('storage/'.$product->getImage()) }}" alt="{{ $product->getName() }}" width="320">
    @endif
    <p>{{ $product->getDescription() }}</p>
    <p>{{ $product->getFormattedPrice() }} — {{ $product->getBrand()->getName() }} / {{ $product->getCategory()->getName() }}</p>
    <p>{{ trans_choice('products.units_available', $product->getStock()) }}</p>
    <p>{{ __('products.average_rating', ['rating' => $product->averageRating()]) }}</p>

    @auth
        <form action="{{ route('orders.checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="items[0][product_id]" value="{{ $product->getId() }}">
            <label>{{ __('products.quantity') }}</label>
            <input type="number" name="items[0][quantity]" value="{{ old('items.0.quantity', 1) }}" min="1" max="{{ $product->getStock() }}">
            <button type="submit" @disabled(! $product->checkAvailability())>{{ __('products.buy') }}</button>
            @error('stock') <span class="error">{{ $message }}</span> @enderror
            @error('items.0.quantity') <span class="error">{{ $message }}</span> @enderror
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
