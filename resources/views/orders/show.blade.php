@extends('layouts.app')

@section('title', 'Pedido #' . $order->id)

@section('content')
    <h1>Pedido #{{ $order->id }}</h1>
    <p>Estado: {{ $order->status }}</p>
    <p>Fecha: {{ $order->order_date->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->getProduct()->getName() }}</td>
                    <td>{{ $item->getQuantity() }}</td>
                    <td>${{ number_format($item->getUnitPrice(), 2) }}</td>
                    <td>${{ number_format($item->getSubtotal(), 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Total: ${{ number_format((float) $order->total_amount, 2) }}</h2>
@endsection
