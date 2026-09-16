@extends('layouts.app')

@section('title', __('products.title_catalog'))

@section('content')
    <h1>{{ __('products.catalog_heading') }}</h1>

    <form action="{{ route('products.search') }}" method="GET">
        <input type="text" name="q" placeholder="{{ __('products.search_placeholder') }}" value="{{ $viewData['term'] ?? '' }}">
        <button type="submit">{{ __('products.search') }}</button>
        @error('q') <span class="error">{{ $message }}</span> @enderror
    </form>

    <form action="{{ route('products.filter') }}" method="GET">
        <label>{{ __('products.category') }}</label>
        <select name="category_id">
            <option value="">{{ __('products.filter_all') }}</option>
            @foreach ($viewData['categories'] ?? [] as $category)
                <option value="{{ $category->getId() }}" @selected(($viewData['selectedCategoryId'] ?? null) === $category->getId())>
                    {{ $category->getName() }}
                </option>
            @endforeach
        </select>

        <label>{{ __('products.brand') }}</label>
        <select name="brand_id">
            <option value="">{{ __('products.filter_all') }}</option>
            @foreach ($viewData['brands'] ?? [] as $brand)
                <option value="{{ $brand->getId() }}" @selected(($viewData['selectedBrandId'] ?? null) === $brand->getId())>
                    {{ $brand->getName() }}
                </option>
            @endforeach
        </select>

        <button type="submit">{{ __('products.filter') }}</button>
    </form>

    <div class="grid">
        @forelse ($viewData['products'] as $product)
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

    {{ $viewData['products']->links() }}
@endsection
