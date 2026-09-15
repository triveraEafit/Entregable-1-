@extends('layouts.admin')

@section('title', __('products.title_edit'))

@section('content')
    <h1>{{ __('products.title_edit') }}</h1>

    <form action="{{ route('admin.products.update', ['id' => $product->getId()]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.products._form', ['product' => $product])
        <button type="submit">{{ __('products.update') }}</button>
    </form>
@endsection
