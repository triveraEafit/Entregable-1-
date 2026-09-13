@extends('layouts.admin')

@section('title', 'Nueva categoría')

@section('content')
    <h1>Nueva categoría</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        @include('admin.categories._form', ['category' => null])
        <button type="submit">Guardar</button>
    </form>
@endsection
