@extends('layouts.admin')

@section('title', __('categories.title_edit'))

@section('content')
    <h1>{{ __('categories.title_edit') }}</h1>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.categories._form')
        <button type="submit">{{ __('categories.update') }}</button>
    </form>
@endsection