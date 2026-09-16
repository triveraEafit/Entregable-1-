@extends('layouts.admin')

@section('title', __('brands.title_create'))

@section('content')
    <h1>{{ __('brands.title_create') }}</h1>

    <form action="{{ route('admin.brands.store') }}" method="POST">
        @csrf
        @include('admin.brands._form', ['brand' => null])
        <button type="submit">{{ __('brands.save') }}</button>
    </form>
@endsection