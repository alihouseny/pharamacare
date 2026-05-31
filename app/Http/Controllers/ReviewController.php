<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller {

    public function store(Request $request, Product $product) {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Only customers who bought this product can review
        $hasBought = auth()->user()->orders()
            ->whereIn('status', ['delivered'])
            ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
            ->exists();

        if (!$hasBought) {
            return back()->with('error', app()->getLocale()==='ar'
                ? 'يمكن فقط للعملاء الذين اشتروا هذا المنتج تقييمه'
                : 'Only verified buyers can review this product');
        }

        // Check already reviewed
        $existing = ProductReview::where('user_id', auth()->id())
            ->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->update(['rating' => $request->rating, 'comment' => $request->comment]);
            return back()->with('success', app()->getLocale()==='ar' ? 'تم تحديث تقييمك' : 'Review updated');
        }

        // Get the order id
        $order = auth()->user()->orders()
            ->whereIn('status', ['delivered'])
            ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
            ->latest()->first();

        ProductReview::create([
            'product_id'  => $product->id,
            'user_id'     => auth()->id(),
            'order_id'    => $order?->id,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
            'is_approved' => true, // auto-approve, admin can change
        ]);

        return back()->with('success', app()->getLocale()==='ar' ? 'شكراً على تقييمك!' : 'Thank you for your review!');
    }

    public function destroy(ProductReview $review) {
        abort_unless($review->user_id === auth()->id() || auth()->user()->isPharmacist(), 403);
        $review->delete();
        return back()->with('success', app()->getLocale()==='ar' ? 'تم حذف التقييم' : 'Review deleted');
    }

    // Admin toggle approve
    public function toggleApprove(ProductReview $review) {
        $review->update(['is_approved' => !$review->is_approved]);
        return back()->with('success', 'Updated');
    }
}
