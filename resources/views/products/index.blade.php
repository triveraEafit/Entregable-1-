@extends('layouts.app')

@section('title', __('products.title_catalog'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('products.catalog_heading') }}</h1>

    <div class="bg-white rounded shadow p-4 mb-8 space-y-4">
        <form action="{{ route('products.search') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <input type="text" name="q" placeholder="{{ __('products.search_placeholder') }}" value="{{ $viewData['term'] ?? '' }}"
                   class="flex-1 min-w-[12rem] border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400">
            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded text-sm hover:bg-slate-700 transition">{{ __('products.search') }}</button>
            @error('q') <span class="text-sm text-red-600 w-full">{{ $message }}</span> @enderror
        </form>

        <form action="{{ route('products.filter') }}" method="GET" class="flex flex-wrap items-end gap-3 border-t pt-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">{{ __('products.category') }}</label>
                <select name="category_id" class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400">
                    <option value="">{{ __('products.filter_all') }}</option>
                    @foreach ($viewData['categories'] ?? [] as $category)
                        <option value="{{ $category->getId() }}" @selected(($viewData['selectedCategoryId'] ?? null) === $category->getId())>
                            {{ $category->getName() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">{{ __('products.brand') }}</label>
                <select name="brand_id" class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400">
                    <option value="">{{ __('products.filter_all') }}</option>
                    @foreach ($viewData['brands'] ?? [] as $brand)
                        <option value="{{ $brand->getId() }}" @selected(($viewData['selectedBrandId'] ?? null) === $brand->getId())>
                            {{ $brand->getName() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded text-sm hover:bg-slate-700 transition">{{ __('products.filter') }}</button>
        </form>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($viewData['products'] as $product)
            <div class="bg-white rounded shadow overflow-hidden flex flex-col hover:shadow-lg transition">
                @if ($product->getImage())
                    <img src="{{ asset('storage/'.$product->getImage()) }}" alt="{{ $product->getName() }}" class="w-full h-44 object-cover">
                @else
                    <div class="w-full h-44 bg-gray-100 flex items-center justify-center text-sm text-gray-400">{{ __('products.no_image') }}</div>
                @endif

                <div class="p-4 flex flex-col flex-1">
                    <a href="{{ route('products.show', ['id' => $product->getId()]) }}" class="block mb-1">
                        <h3 class="font-semibold text-gray-800 hover:text-slate-600 transition">{{ $product->getName() }}</h3>
                    </a>
                    <p class="text-sm text-gray-500 mb-3">{{ $product->getBrand()->getName() }} · {{ $product->getCategory()->getName() }}</p>
                    <p class="text-lg font-bold text-gray-800 mt-auto">{{ $product->getFormattedPrice() }}</p>
                    <p class="mt-2">
                        @if ($product->checkAvailability())
                            <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded">{{ __('products.available') }}</span>
                        @else
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs font-medium px-2 py-1 rounded">{{ __('products.sold_out') }}</span>
                        @endif
                    </p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 sm:col-span-2 lg:col-span-3">{{ __('products.not_found') }}</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $viewData['products']->links() }}
    </div>
@endsection
