@extends('layouts.app')

@section('title', 'Mis pedidos')

@section('content')
    <h1>Mis pedidos</h1>

    @forelse ($orders as $order)
        <div class="order">
            <a href="{{ route('orders.show', $order->id) }}">
                Pedido #{{ $order->id }} — {{ $order->status }} — {{ $order->order_date->format('d/m/Y') }}
            </a>
            <strong>Total: ${{ number_format((float) $order->total_amount, 2) }}</strong>
        </div>
    @empty
        <p>No tienes pedidos aún.</p>
    @endforelse

    {{ $orders->links() }}
@endsection
