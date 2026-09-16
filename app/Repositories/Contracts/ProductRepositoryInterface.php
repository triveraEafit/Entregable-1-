<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

interface ProductRepositoryInterface
{
    public function paginateForAdmin(int $perPage = 15): LengthAwarePaginator;

    public function paginateActive(int $perPage = 12): LengthAwarePaginator;

    public function searchByName(string $term, int $perPage = 12): LengthAwarePaginator;

    public function filterByCategoryAndBrand(?int $categoryId, ?int $brandId, int $perPage = 12): LengthAwarePaginator;

    public function findActiveWithRelations(string $id): Product;

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data, ?UploadedFile $image = null): Product;

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Product $product, array $data, ?UploadedFile $image = null): Product;

    public function deactivate(Product $product): Product;

    /**
     * @return Collection<int, Product>
     */
    public function topSelling(int $limit = 5): Collection;

    /**
     * @return Collection<int, Product>
     */
    public function topCommented(int $limit = 4): Collection;
}
