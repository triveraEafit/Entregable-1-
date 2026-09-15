<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EloquentBrandRepository implements BrandRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Brand::query()
            ->withCount('products')
            ->latest()
            ->paginate($perPage);
    }

    public function all(): Collection
    {
        return Brand::query()->orderBy('name')->get();
    }

    public function create(array $data): Brand
    {
        return Brand::create($data);
    }

    public function update(Brand $brand, array $data): Brand
    {
        $brand->update($data);

        return $brand->fresh();
    }

    public function delete(Brand $brand): bool
    {
        return (bool) $brand->delete();
    }
}
