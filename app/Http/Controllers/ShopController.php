<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller {

    public function index(Request $request) {
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();

        $query = Product::with('category')
            ->where('is_active', true);

        // Filter by category
        if ($request->category) {
            $cat = Category::where('slug', $request->category)->firstOrFail();
            $catIds = Category::where('parent_id', $cat->id)->pluck('id')->push($cat->id);
            $query->whereIn('category_id', $catIds);
        }

        // Search by name OR active ingredient
        if ($request->q) {
            $q = $request->q;
            $query->where(function($sq) use ($q) {
                $sq->where('name_ar', 'like', "%$q%")
                   ->orWhere('name_en', 'like', "%$q%")
                   ->orWhere('active_ingredient', 'like', "%$q%")
                   ->orWhere('barcode', $q);
            });
        }

        // Other filters
        if ($request->filter === 'featured') $query->where('is_featured', true);
        if ($request->filter === 'sale')     $query->whereNotNull('sale_price');
        if ($request->filter === 'otc')      $query->where('requires_prescription', false);
        if ($request->filter === 'rx')       $query->where('requires_prescription', true);

        $products   = $query->latest()->paginate(16)->withQueryString();
        $activeCategory = $request->category ? Category::where('slug', $request->category)->first() : null;

        return view('shop.index', compact('products', 'categories', 'activeCategory'));
    }

    public function show($slug) {
        $product  = Product::with(['category','expiries' => fn($q) => $q->where('status','active')->orderBy('expiry_date')])
            ->where('slug', $slug)->where('is_active', true)->firstOrFail();
        $related  = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)->where('is_active', true)->limit(4)->get();
        return view('shop.product', compact('product', 'related'));
    }

    public function home() {
        $categories  = Category::where('is_active', true)->whereNull('parent_id')->orderBy('sort_order')->get();
        $featured    = Product::where('is_featured', true)->where('is_active', true)->limit(8)->get();
        $newArrivals = Product::where('is_active', true)->latest()->limit(8)->get();
        $onSale      = Product::whereNotNull('sale_price')->where('is_active', true)->limit(4)->get();
        return view('shop.home', compact('categories', 'featured', 'newArrivals', 'onSale'));
    }
}
