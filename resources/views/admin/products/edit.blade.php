@extends('layouts.admin')

@section('title', 'Editar producto')

@section('content')
    <h1>Editar producto</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.products._form')
        <button type="submit">Actualizar</button>
    </form>
@endsection
