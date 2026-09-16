<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class EloquentProductRepository implements ProductRepositoryInterface
{
    private const IMAGE_DISK = 'public';

    private const IMAGE_DIRECTORY = 'products';

    private const CANCELLED_ORDER_STATUS = 'cancelado';

    /**
     * Brand and category are eager loaded to avoid N+1 queries in the admin table.
     */
    public function paginateForAdmin(int $perPage = 15): LengthAwarePaginator
    {
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

    /**
     * Interesting feature: search products by name.
     * An empty term lists every active product. The term is kept in the pagination links.
     */
    public function searchByName(string $term, int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()
            ->with(['brand', 'category'])
            ->where('active', true)
            ->when($term !== '', function (Builder $query) use ($term): void {
                $query->where('name', 'like', "%{$term}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Interesting feature: filter products by category and/or brand.
     * The selected filters are kept in the pagination links.
     */
    public function filterByCategoryAndBrand(?int $categoryId, ?int $brandId, int $perPage = 12): LengthAwarePaginator
    {
        return Product::query()
            ->with(['brand', 'category'])
            ->where('active', true)
            ->when($categoryId, fn (Builder $query) => $query->where('category_id', $categoryId))
            ->when($brandId, fn (Builder $query) => $query->where('brand_id', $brandId))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findActiveWithRelations(string $id): Product
    {
        return Product::query()
            ->with(['brand', 'category', 'reviews.user'])
            ->where('active', true)
            ->findOrFail($id);
    }

    public function create(array $data, ?UploadedFile $image = null): Product
    {
        $product = new Product($data);

        if ($image !== null) {
            $product->setImage($this->storeImage($image));
        }

        $product->save();

        return $product;
    }

    /**
     * The previous image is deleted only after the product was saved with the new one.
     */
    public function update(Product $product, array $data, ?UploadedFile $image = null): Product
    {
        $previousImage = $product->getImage();
        $product->fill($data);

        if ($image !== null) {
            $product->setImage($this->storeImage($image));
        }

        $product->save();

        if ($image !== null && $previousImage !== null) {
            Storage::disk(self::IMAGE_DISK)->delete($previousImage);
        }

        return $product;
    }

    /**
     * Products are never deleted, because their order items must keep pointing to them.
     */
    public function deactivate(Product $product): Product
    {
        $product->setActive(false);
        $product->save();

        return $product;
    }

    /**
     * Interesting feature: ranks active products by the units sold in orders that were not cancelled.
     */
    public function topSelling(int $limit = 5): Collection
    {
        $fromNonCancelledOrders = function (Builder $orderItems): void {
            $orderItems->whereHas('order', function (Builder $order): void {
                $order->where('status', '!=', self::CANCELLED_ORDER_STATUS);
            });
        };

        return Product::query()
            ->with(['brand', 'category'])
            ->where('active', true)
            ->whereHas('orderItems', $fromNonCancelledOrders)
            ->withSum(['orderItems as units_sold' => $fromNonCancelledOrders], 'quantity')
            ->orderByDesc('units_sold')
            ->orderBy('name')
            ->take($limit)
            ->get();
    }

    /**
     * Interesting feature: top N active products with the most reviews.
     */
    public function topCommented(int $limit = 4): Collection
    {
        return Product::query()
            ->where('active', true)
            ->withCount('reviews')
            ->orderByDesc('reviews_count')
            ->take($limit)
            ->get();
    }

    private function storeImage(UploadedFile $image): string
    {
        $path = $image->store(self::IMAGE_DIRECTORY, self::IMAGE_DISK);

        if ($path === false) {
            throw new RuntimeException(__('products.image_upload_failed'));
        }

        return $path;
    }
}
