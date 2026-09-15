@extends('layouts.admin')

@section('title', __('products.title_edit'))

@section('content')
    <h1>{{ __('products.title_edit') }}</h1>

    <form action="{{ route('admin.products.update', ['id' => $viewData['product']->getId()]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.products._form', [
            'product' => $viewData['product'],
            'brands' => $viewData['brands'],
            'categories' => $viewData['categories'],
        ])
        <button type="submit">{{ __('products.update') }}</button>
    </form>
@endsection
