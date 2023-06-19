<?php

namespace AvoRed\Framework\Catalog\Controllers;

use App\Models\ProductReview;
use AvoRed\Framework\Catalog\Requests\ProductRequest;
use AvoRed\Framework\Database\Contracts\CategoryModelInterface;
use AvoRed\Framework\Database\Contracts\ProductModelInterface;
use AvoRed\Framework\Database\Models\Product;
use AvoRed\Framework\Tab\Tab;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::query()
            ->whereHas('user')
            ->whereHas('product')
            ->with(['user', 'product'])->paginate();
        return view('avored::catalog.review.index')
            ->with('reviews', $reviews);
    }

    public function update(Request $request, ProductReview $review, $status)
    {
        if (!in_array($status, ['publish', 'unpublish']))
            return redirect()->route('admin.product-review.index');

        $review->status = !$review->status;
        $review->save();

        return redirect()->route('admin.product-review.index');
    }

    public function destroy(ProductReview $review)
    {
        $review->delete();

        return new JsonResponse([
            'success' => true,
            'message' => __('avored::system.success_delete_message', ['review' => 'Review'])
        ]);
    }
}
