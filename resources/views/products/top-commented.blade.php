@extends('layouts.app')

@section('title', __('products.title_top_commented'))

@section('content')
    <h1>{{ __('products.top_commented_heading') }}</h1>

    <ol>
        @foreach ($viewData['products'] as $product)
            <li>
                <a href="{{ route('products.show', ['id' => $product->getId()]) }}">{{ $product->getName() }}</a>
                — {{ trans_choice('products.comments_count', $product->getReviewsCount()) }}
            </li>
        @endforeach
    </ol>
@endsection
