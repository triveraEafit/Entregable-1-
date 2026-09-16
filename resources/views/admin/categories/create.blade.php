@extends('layouts.admin')

@section('title', __('categories.title_create'))

@section('content')
    <h1>{{ __('categories.title_create') }}</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        @include('admin.categories._form', ['category' => null])
        <button type="submit">{{ __('categories.save') }}</button>
    </form>
@endsection
