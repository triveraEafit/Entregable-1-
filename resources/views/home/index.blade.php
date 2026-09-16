@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <h1>{{ __('home.heading') }}</h1>
    <p>{{ __('home.intro') }}</p>

    <ul>
        <li><a href="{{ route('products.index') }}">{{ __('home.catalog_link') }}</a></li>
        <li><a href="{{ route('products.top-selling') }}">{{ __('home.top_selling_link') }}</a></li>
        <li><a href="{{ route('products.top-commented') }}">{{ __('home.top_commented_link') }}</a></li>
    </ul>
@endsection
