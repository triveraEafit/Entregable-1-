<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService
    ) {}

    public function index(Request $request): View
    {
        $data = [
            // Eager loading para no disparar N+1 al listar items y productos.
            'orders' => $request->user()
                ->orders()
                ->with('orderItems.product')
                ->latest()
                ->paginate(10),
        ];

        return view('orders.index', $data);
    }

    public function checkout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $order = $this->orderService->checkout($request->user(), $validated['items']);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['stock' => $e->getMessage()]);
        }

        return redirect()
            ->route('orders.show', $order)
            ->with('status', 'Pedido realizado con éxito.');
    }

    public function show(int $id, Request $request): View
    {
        $order = $request->user()
            ->orders()
            ->with('orderItems.product')
            ->findOrFail($id);

        return view('orders.show', ['order' => $order]);
    }
}
