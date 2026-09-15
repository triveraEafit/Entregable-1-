@extends('layouts.admin')

@section('title', __('products.title_create'))

@section('content')
    <h1>{{ __('products.title_create') }}</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form', [
            'product' => null,
            'brands' => $viewData['brands'],
            'categories' => $viewData['categories'],
        ])
        <button type="submit">{{ __('products.save') }}</button>
    </form>
@endsection
