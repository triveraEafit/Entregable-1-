@extends('layouts.app')

@section('title', __('products.title_top_selling'))

@section('content')
    <h1>{{ __('products.top_selling_heading') }}</h1>

    @if ($viewData['products']->isEmpty())
        <p>{{ __('products.no_sales') }}</p>
    @else
        <ol>
            @foreach ($viewData['products'] as $product)
                <li>
                    <a href="{{ route('products.show', ['id' => $product->getId()]) }}">{{ $product->getName() }}</a>
                    — {{ $product->getBrand()->getName() }} · {{ $product->getFormattedPrice() }}
                    — {{ trans_choice('products.units_sold', $product->getUnitsSold()) }}
                </li>
            @endforeach
        </ol>
    @endif
@endsection
