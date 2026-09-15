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
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * DIP: the controller depends on the repository interface, not on Eloquent.
     */
    public function __construct(
        private readonly ProductRepositoryInterface $products
    ) {}

    public function index(): View
    {
        $viewData = [
            'products' => $this->products->paginateForAdmin(),
        ];

        return view('admin.products.index', $viewData);
    }

    public function create(): View
    {
        $viewData = [
            'brands' => Brand::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ];

        return view('admin.products.create', $viewData);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->products->create($request->safe()->except('image'), $request->file('image'));

        return redirect()
            ->route('admin.products.index')
            ->with('status', __('products.created'));
    }

    public function edit(string $id): View
    {
        $viewData = [
            'product' => Product::findOrFail($id),
            'brands' => Brand::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ];

        return view('admin.products.edit', $viewData);
    }

    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $this->products->update($product, $request->safe()->except('image'), $request->file('image'));

        return redirect()
            ->route('admin.products.index')
            ->with('status', __('products.updated'));
    }

    public function deactivate(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $this->products->deactivate($product);

        return redirect()
            ->route('admin.products.index')
            ->with('status', __('products.deactivated'));
    }
}
