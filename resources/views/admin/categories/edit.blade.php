@extends('layouts.admin')

@section('title', 'Editar categoría')

@section('content')
    <h1>Editar categoría</h1>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.categories._form')
        <button type="submit">Actualizar</button>
    </form>
@endsection
