@extends('layouts.admin')

@section('title', __('categories.title_edit'))

@section('content')
    <h1>{{ __('categories.title_edit') }}</h1>

    <form action="{{ route('admin.categories.update', $viewData['category']) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.categories._form', ['category' => $viewData['category']])
        <button type="submit">{{ __('categories.update') }}</button>
    </form>
@endsection