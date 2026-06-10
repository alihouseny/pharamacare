<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller {

    // AJAX autocomplete search
    public function search(Request $request) {
        $q = $request->get('q', '');
        if (strlen($q) < 2) return response()->json([]);

        $products = Product::where('is_active', true)
            ->where(function($sq) use ($q) {
                $sq->where('name_ar', 'like', "%$q%")
                   ->orWhere('name_en', 'like', "%$q%")
                   ->orWhere('active_ingredient', 'like', "%$q%")
                   ->orWhere('barcode', $q);
            })
            ->with('category')
            ->limit(8)
            ->get()
            ->map(fn($p) => [
                'id'         => $p->id,
                'name'       => $p->name,
                'ingredient' => $p->active_ingredient,
                'price'      => number_format($p->current_price, 2),
                'image'      => $p->image ? asset('storage/'.$p->image) : null,
                'slug'       => $p->slug,
                'category'   => $p->category?->name,
                'in_stock'   => $p->stock > 0,
            ]);

        return response()->json($products);
    }

    public function index(Request $request) {
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();

        $query = Product::with('category')->where('is_active', true);

        if ($request->category) {
            $cat    = Category::where('slug', $request->category)->firstOrFail();
            $catIds = Category::where('parent_id', $cat->id)->pluck('id')->push($cat->id);
            $query->whereIn('category_id', $catIds);
        }
        if ($request->q) {
            $q = $request->q;
            $query->where(function($sq) use ($q) {
                $sq->where('name_ar','like',"%$q%")
                   ->orWhere('name_en','like',"%$q%")
                   ->orWhere('active_ingredient','like',"%$q%")
                   ->orWhere('barcode',$q);
            });
        }
        if ($request->filter === 'featured') $query->where('is_featured', true);
        if ($request->filter === 'sale')     $query->whereNotNull('sale_price');
        if ($request->filter === 'otc')      $query->where('requires_prescription', false);
        if ($request->filter === 'rx')       $query->where('requires_prescription', true);

        if ($request->sort === 'price_asc')  $query->orderBy('price');
        elseif ($request->sort === 'price_desc') $query->orderByDesc('price');
        elseif ($request->sort === 'name')   $query->orderBy('name_ar');
        else                                 $query->latest();

        $products       = $query->paginate(16)->withQueryString();
        $activeCategory = $request->category ? Category::where('slug', $request->category)->first() : null;

        return view('shop.index', compact('products', 'categories', 'activeCategory'));
    }

    public function show($slug) {
        $product = Product::with(['category', 'expiries' => fn($q) => $q->where('status','active')->orderBy('expiry_date')])
            ->where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Smart recommendations: same category + frequently bought together
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)->where('is_active', true)->limit(4)->get();

        // Frequently bought together (from order history)
        $boughtTogether = \App\Models\OrderItem::where('product_id', '!=', $product->id)
            ->whereIn('order_id', function($q) use ($product) {
                $q->select('order_id')->from('order_items')->where('product_id', $product->id);
            })
            ->select('product_id', \Illuminate\Support\Facades\DB::raw('COUNT(*) as times'))
            ->groupBy('product_id')
            ->orderByDesc('times')
            ->limit(4)
            ->with('product')
            ->get()
            ->filter(fn($i) => $i->product && $i->product->is_active)
            ->map(fn($i) => $i->product);

        return view('shop.product', compact('product', 'related', 'boughtTogether'));
    }

    public function home() {
        $categories  = Category::where('is_active', true)->whereNull('parent_id')->withCount('products')->orderBy('sort_order')->get();
        $featured    = Product::where('is_featured', true)->where('is_active', true)->limit(8)->get();
        $newArrivals = Product::where('is_active', true)->latest()->limit(8)->get();
        $onSale      = Product::whereNotNull('sale_price')->where('is_active', true)->limit(4)->get();
        return view('shop.home', compact('categories', 'featured', 'newArrivals', 'onSale'));
    }
}
