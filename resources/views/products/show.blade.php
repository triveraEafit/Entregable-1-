@extends('layouts.app')

@section('title', $viewData['product']->getName())

@section('content')
    <div class="bg-white rounded shadow overflow-hidden mb-8">
        <div class="grid md:grid-cols-2 gap-6 p-6">
            <div>
                @if ($viewData['product']->getImage())
                    <img src="{{ asset('storage/'.$viewData['product']->getImage()) }}" alt="{{ $viewData['product']->getName() }}" class="w-full rounded object-cover">
                @else
                    <div class="w-full h-64 bg-gray-100 rounded flex items-center justify-center text-sm text-gray-400">{{ __('products.no_image') }}</div>
                @endif
            </div>

            <div class="flex flex-col">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $viewData['product']->getName() }}</h1>
                <p class="text-sm text-gray-500 mb-4">{{ $viewData['product']->getBrand()->getName() }} / {{ $viewData['product']->getCategory()->getName() }}</p>
                <p class="text-gray-700 mb-4">{{ $viewData['product']->getDescription() }}</p>

                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $viewData['product']->getFormattedPrice() }}</p>
                <p class="text-sm text-gray-600 mb-1">{{ trans_choice('products.units_available', $viewData['product']->getStock()) }}</p>
                <p class="text-sm text-gray-600 mb-4">{{ __('products.average_rating', ['rating' => $viewData['product']->averageRating()]) }}</p>

                @auth
                    <form action="{{ route('orders.checkout') }}" method="POST" class="border-t pt-4 mt-auto">
                        @csrf
                        <input type="hidden" name="items[0][product_id]" value="{{ $viewData['product']->getId() }}">
                        <div class="flex items-end gap-3 flex-wrap">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">{{ __('products.quantity') }}</label>
                                <input type="number" name="items[0][quantity]" value="{{ old('items.0.quantity', 1) }}" min="1" max="{{ $viewData['product']->getStock() }}"
                                       class="w-24 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400">
                            </div>
                            <button type="submit" @disabled(! $viewData['product']->checkAvailability())
                                    class="bg-slate-800 text-white px-5 py-2 rounded text-sm hover:bg-slate-700 transition disabled:bg-gray-300 disabled:cursor-not-allowed">
                                {{ __('products.buy') }}
                            </button>
                        </div>
                        @error('stock') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        @error('items.0.quantity') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </form>
                @endauth
            </div>
        </div>
    </div>

    @auth
        <div class="bg-white rounded shadow p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Dejar una reseña</h2>
            <form action="{{ route('reviews.store', $viewData['product']->getId()) }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Calificación (1-5)</label>
                    <input type="number" name="rating" min="1" max="5"
                           class="w-24 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Comentario</label>
                    <textarea name="comment" rows="3"
                              class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400"></textarea>
                </div>
                <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded text-sm hover:bg-slate-700 transition">Enviar reseña</button>
            </form>
        </div>
    @endauth

    <h2 class="text-lg font-semibold text-gray-800 mb-4">Reseñas ({{ $viewData['product']->getReviews()->count() }})</h2>

    <div class="space-y-3">
        @forelse ($viewData['product']->getReviews()->sortByDesc(fn ($review) => $review->getCreatedAtReview()) as $review)
            <div class="bg-white rounded shadow p-4">
                <div class="flex items-center justify-between flex-wrap gap-2 mb-1">
                    <strong class="text-gray-800">{{ $review->user->getName() }}</strong>
                    <time class="text-xs text-gray-500">{{ \Illuminate\Support\Carbon::parse($review->getCreatedAtReview())->format('d/m/Y') }}</time>
                </div>
                <span class="text-amber-500 text-sm">{{ str_repeat('★', $review->getRating()) }}{{ str_repeat('☆', 5 - $review->getRating()) }}</span>
                @if ($review->getComment())
                    <p class="text-gray-700 text-sm mt-2">{{ $review->getComment() }}</p>
                @endif
            </div>
        @empty
            <p class="text-gray-500">Aún no hay reseñas todavía. ¡Sé el primero en dejar una!</p>
        @endforelse
    </div>
@endsection
