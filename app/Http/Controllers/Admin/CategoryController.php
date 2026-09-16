<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categories
    ) {}

    public function index(): View
    {
        $viewData = [
            'categories' => $this->categories->paginate(),
        ];

        return view('admin.categories.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->categories->create($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Categoría creada correctamente.');
    }

    public function edit(string $id): View
    {
        $viewData = [
            'category' => Category::findOrFail($id),
        ];

        return view('admin.categories.edit')->with('viewData', $viewData);
    }

    public function update(UpdateCategoryRequest $request, string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $this->categories->update($category, $request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Categoría actualizada correctamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        $this->categories->delete($category);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Categoría eliminada.');
    }
}
