@extends('layouts.admin')

@section('title', 'Nuevo producto')

@section('content')
    <h1>Nuevo producto</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form', ['product' => null])
        <button type="submit">Guardar</button>
    </form>
@endsection
