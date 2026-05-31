<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller {

    public function index() {
        $items = auth()->user()->wishlist()->with('product.category')->latest()->paginate(16);
        return view('wishlist.index', compact('items'));
    }

    public function toggle(Request $request, Product $product) {
        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();
            $inWishlist = false;
            $msg = app()->getLocale()==='ar' ? 'تم الحذف من المفضلة' : 'Removed from wishlist';
        } else {
            Wishlist::create(['user_id' => auth()->id(), 'product_id' => $product->id]);
            $inWishlist = true;
            $msg = app()->getLocale()==='ar' ? 'تم الإضافة للمفضلة' : 'Added to wishlist';
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'in_wishlist' => $inWishlist, 'message' => $msg]);
        }
        return back()->with('success', $msg);
    }

    public function count() {
        $count = auth()->check() ? auth()->user()->wishlist()->count() : 0;
        return response()->json(['count' => $count]);
    }
}
