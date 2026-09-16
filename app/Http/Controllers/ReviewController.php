<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, string $productId): RedirectResponse
    {
        $product = Product::findOrFail($productId);

        Review::create([
            'rating' => $request->validated('rating'),
            'comment' => $request->validated('comment'),
            'created_at_review' => now(),
            'user_id' => $request->user()->getId(),
            'product_id' => $product->getId(),
        ]);

        return back()->with('status', 'Gracias por tu reseña.');
    }
}
