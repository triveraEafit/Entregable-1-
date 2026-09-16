<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function __construct(
        private readonly BrandRepositoryInterface $brands
    ) {}

    public function index(): View
    {
        $viewData = [
            'brands' => $this->brands->paginate(),
        ];

        return view('admin.brands.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(StoreBrandRequest $request): RedirectResponse
    {
        $this->brands->create($request->validated());

        return redirect()
            ->route('admin.brands.index')
            ->with('status', 'Marca creada correctamente.');
    }

    public function edit(string $id): View
    {
        $viewData = [
            'brand' => Brand::findOrFail($id),
        ];

        return view('admin.brands.edit')->with('viewData', $viewData);
    }

    public function update(UpdateBrandRequest $request, string $id): RedirectResponse
    {
        $brand = Brand::findOrFail($id);
        $this->brands->update($brand, $request->validated());

        return redirect()
            ->route('admin.brands.index')
            ->with('status', 'Marca actualizada correctamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $brand = Brand::findOrFail($id);
        $this->brands->delete($brand);

        return redirect()
            ->route('admin.brands.index')
            ->with('status', 'Marca eliminada.');
    }
}
