@extends('layouts.app')

@section('title', __('products.title_top_selling'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('products.top_selling_heading') }}</h1>

    @if ($viewData['products']->isEmpty())
        <div class="bg-white rounded shadow p-6 text-gray-500">{{ __('products.no_sales') }}</div>
    @else
        <ol class="space-y-3">
            @foreach ($viewData['products'] as $product)
                <li class="bg-white rounded shadow p-4 flex flex-wrap items-center gap-4">
                    <span class="w-9 h-9 shrink-0 bg-slate-800 text-white rounded-full flex items-center justify-center font-bold text-sm">{{ $loop->iteration }}</span>

                    <div class="flex-1 min-w-[12rem]">
                        <a href="{{ route('products.show', ['id' => $product->getId()]) }}" class="font-semibold text-gray-800 hover:text-slate-600 transition">{{ $product->getName() }}</a>
                        <p class="text-sm text-gray-500">{{ $product->getBrand()->getName() }} · {{ $product->getFormattedPrice() }}</p>
                    </div>

                    <span class="bg-green-100 text-green-700 text-xs font-medium px-3 py-1 rounded">{{ trans_choice('products.units_sold', $product->getUnitsSold()) }}</span>
                </li>
            @endforeach
        </ol>
    @endif
@endsection
