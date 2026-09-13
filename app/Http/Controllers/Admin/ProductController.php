<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * DIP: el controlador depende de la interfaz, no de Eloquent directamente.
     */
    public function __construct(
        private readonly ProductRepositoryInterface $products
    ) {}

    public function index(): View
    {
        $data = [
            'products' => $this->products->paginateForAdmin(),
        ];

        return view('admin.products.index', $data);
    }

    public function create(): View
    {
        $data = [
            'brands' => Brand::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ];

        return view('admin.products.create', $data);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $this->products->create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Producto creado correctamente.');
    }

    public function edit(Product $product): View
    {
        $data = [
            'product' => $product,
            'brands' => Brand::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ];

        return view('admin.products.edit', $data);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $this->products->update($product, $validated);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Producto actualizado correctamente.');
    }

    /**
     * Se desactiva en lugar de borrar físicamente (soft delete de negocio).
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->products->update($product, ['active' => false]);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Producto desactivado.');
    }
}
