@extends('layouts.admin')

@section('title', __('brands.title_edit'))

@section('content')
    <h1>{{ __('brands.title_edit') }}</h1>

    <form action="{{ route('admin.brands.update', $viewData['brand']) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.brands._form', ['brand' => $viewData['brand']])
        <button type="submit">{{ __('brands.update') }}</button>
    </form>
@endsection