@extends('layouts.app')

@section('title', __('products.title_catalog'))

@section('content')
    <h1>{{ __('products.catalog_heading') }}</h1>

    <form action="{{ route('products.search') }}" method="GET">
        <input type="text" name="q" placeholder="{{ __('products.search_placeholder') }}" value="{{ $term ?? '' }}">
        <button type="submit">{{ __('products.search') }}</button>
        @error('q') <span class="error">{{ $message }}</span> @enderror
    </form>

    <div class="grid">
        @forelse ($products as $product)
            <div class="card">
                @if ($product->getImage())
                    <img src="{{ asset('storage/'.$product->getImage()) }}" alt="{{ $product->getName() }}" width="200">
                @endif
                <a href="{{ route('products.show', ['id' => $product->getId()]) }}">
                    <h3>{{ $product->getName() }}</h3>
                </a>
                <p>{{ $product->getBrand()->getName() }} · {{ $product->getCategory()->getName() }}</p>
                <p>{{ $product->getFormattedPrice() }}</p>
                <p>{{ $product->checkAvailability() ? __('products.available') : __('products.sold_out') }}</p>
            </div>
        @empty
            <p>{{ __('products.not_found') }}</p>
        @endforelse
    </div>

    {{ $products->links() }}
@endsection
