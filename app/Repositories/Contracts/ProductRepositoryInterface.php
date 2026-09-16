<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function paginateForAdmin(int $perPage = 15): LengthAwarePaginator;

    public function paginateActive(int $perPage = 12): LengthAwarePaginator;

    public function searchByName(string $term, int $perPage = 12): LengthAwarePaginator;

    public function findWithRelations(int $id): Product;

    public function create(array $data): Product;

    public function update(Product $product, array $data): Product;

    public function delete(Product $product): bool;

    public function topCommented(int $limit = 4): Collection;

    public function filterByCategoryAndBrand(?int $categoryId, ?int $brandId, int $perPage = 12): LengthAwarePaginator;
}
