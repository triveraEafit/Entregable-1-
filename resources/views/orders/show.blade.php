@extends('layouts.app')

@section('title', 'Pedido #' . $order->id)

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Pedido #{{ $order->id }}</h1>
    <p class="text-sm text-gray-600">Estado: {{ $order->status }}</p>
    <p class="text-sm text-gray-600 mb-6">Fecha: {{ $order->order_date->format('d/m/Y H:i') }}</p>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Producto</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Cantidad</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Precio unitario</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->getProduct()->getName() }}</td>
                        <td class="px-4 py-3">{{ $item->getQuantity() }}</td>
                        <td class="px-4 py-3">${{ number_format($item->getUnitPrice(), 2) }}</td>
                        <td class="px-4 py-3">${{ number_format($item->getSubtotal(), 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2 class="text-xl font-bold text-gray-800 mt-6 text-right">Total: ${{ number_format((float) $order->total_amount, 2) }}</h2>
@endsection
