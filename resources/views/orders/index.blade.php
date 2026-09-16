@extends('layouts.app')

@section('title', 'Mis pedidos')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Mis pedidos</h1>

    <div class="space-y-3">
        @forelse ($orders as $order)
            <div class="bg-white rounded shadow p-4 flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('orders.show', $order->id) }}" class="font-semibold text-gray-800 hover:text-slate-600 transition">
                    Pedido #{{ $order->id }} — {{ $order->status }} — {{ $order->order_date->format('d/m/Y') }}
                </a>
                <strong class="text-gray-800">Total: ${{ number_format((float) $order->total_amount, 2) }}</strong>
            </div>
        @empty
            <div class="bg-white rounded shadow p-6 text-gray-500">No tienes pedidos aún.</div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endsection
