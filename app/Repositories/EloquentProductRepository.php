<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function paginateForAdmin(int $perPage = 15): LengthAwarePaginator
    {
        // Eager loading para evitar N+1 al mostrar marca/categoria en la tabla.
        return Product::query()
            ->with(['brand', 'category'])
            ->latest()
            ->paginate($perPage);
    }

    public function paginateActive(int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()
            ->with(['brand', 'category'])
            ->where('active', true)
            ->latest()
            ->paginate($perPage);
    }

    public function searchByName(string $term, int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()
            ->with(['brand', 'category'])
            ->where('active', true)
            ->where('name', 'like', "%{$term}%")
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Funcionalidad interesante: filtro de productos por categoría y/o marca.
     */
    public function filterByCategoryAndBrand(?int $categoryId, ?int $brandId, int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()
            ->with(['brand', 'category'])
            ->where('active', true)
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->when($brandId, fn ($query) => $query->where('brand_id', $brandId))
            ->latest()
            ->paginate($perPage);
    }

    public function findWithRelations(int $id): Product
    {
        return Product::query()
            ->with(['brand', 'category', 'reviews.user'])
            ->findOrFail($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->fresh(['brand', 'category']);
    }

    public function delete(Product $product): bool
    {
        return (bool) $product->delete();
    }

    /**
     * Funcionalidad interesante: top N productos con mas comentarios (reviews).
     */
    public function topCommented(int $limit = 4): Collection
    {
        return Product::query()
            ->withCount('reviews')
            ->orderByDesc('reviews_count')
            ->take($limit)
            ->get();
    }
}
