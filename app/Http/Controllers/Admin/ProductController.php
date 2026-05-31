<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductExpiry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller {

    public function index(Request $request) {
        $query = Product::with('category');
        if ($request->q) {
            $q = $request->q;
            $query->where(function($sq) use ($q) {
                $sq->where('name_ar','like',"%$q%")
                   ->orWhere('name_en','like',"%$q%")
                   ->orWhere('active_ingredient','like',"%$q%");
            });
        }
        if ($request->category) $query->where('category_id', $request->category);
        if ($request->stock === 'low') $query->where('stock','<=',10);
        $products   = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::orderBy('name_ar')->get();
        return view('admin.products.index', compact('products','categories'));
    }

    public function create() {
        $categories = Category::where('is_active',true)->orderBy('name_ar')->get();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name_ar'               => 'required|string|max:200',
            'name_en'               => 'required|string|max:200',
            'category_id'           => 'required|exists:categories,id',
            'description_ar'        => 'nullable|string',
            'description_en'        => 'nullable|string',
            'active_ingredient'     => 'nullable|string|max:200',
            'manufacturer'          => 'nullable|string|max:200',
            'barcode'               => 'nullable|string|unique:products',
            'requires_prescription' => 'boolean',
            'price'                 => 'required|numeric|min:0',
            'sale_price'            => 'nullable|numeric|min:0',
            'stock'                 => 'required|integer|min:0',
            'min_stock_alert'       => 'integer|min:1',
            'dosage_form'           => 'nullable|string',
            'strength'              => 'nullable|string',
            'package_size'          => 'nullable|string',
            'is_featured'           => 'boolean',
            'image'                 => 'nullable|image|max:2048',
        ]);
        $data['slug'] = Str::slug($request->name_en) . '-' . uniqid();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products','public');
        }
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success','تم إنشاء المنتج بنجاح');
    }

    public function edit(Product $product) {
        $categories = Category::where('is_active',true)->orderBy('name_ar')->get();
        return view('admin.products.form', compact('product','categories'));
    }

    public function update(Request $request, Product $product) {
        $data = $request->validate([
            'name_ar'               => 'required|string|max:200',
            'name_en'               => 'required|string|max:200',
            'category_id'           => 'required|exists:categories,id',
            'description_ar'        => 'nullable|string',
            'description_en'        => 'nullable|string',
            'active_ingredient'     => 'nullable|string|max:200',
            'manufacturer'          => 'nullable|string|max:200',
            'requires_prescription' => 'boolean',
            'price'                 => 'required|numeric|min:0',
            'sale_price'            => 'nullable|numeric|min:0',
            'stock'                 => 'required|integer|min:0',
            'min_stock_alert'       => 'integer|min:1',
            'dosage_form'           => 'nullable|string',
            'strength'              => 'nullable|string',
            'package_size'          => 'nullable|string',
            'is_featured'           => 'boolean',
            'is_active'             => 'boolean',
            'image'                 => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products','public');
        }
        $product->update($data);
        return back()->with('success','تم التحديث بنجاح');
    }

    public function expiry(Product $product) {
        $batches = $product->expiries()->orderBy('expiry_date')->get();
        return view('admin.expiry.product', compact('product','batches'));
    }

    public function addBatch(Request $request, Product $product) {
        $data = $request->validate([
            'batch_number'     => 'required|string',
            'expiry_date'      => 'required|date|after:today',
            'manufacture_date' => 'nullable|date',
            'quantity'         => 'required|integer|min:1',
        ]);
        $data['remaining_quantity'] = $data['quantity'];
        $data['product_id']         = $product->id;
        $product->expiries()->create($data);
        $product->increment('stock', $data['quantity']);
        return back()->with('success','تم إضافة الدفعة');
    }

    public function analytics(Product $product) {
        // Sales over last 12 months
        $salesByMonth = OrderItem::where('product_id', $product->id)
            ->join('orders','orders.id','=','order_items.order_id')
            ->where('orders.created_at', '>=', now()->subMonths(12))
            ->whereIn('orders.status', ['delivered','shipped','preparing'])
            ->selectRaw('DATE_FORMAT(orders.created_at, "%Y-%m") as month, SUM(order_items.quantity) as qty, SUM(order_items.total) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Total stats
        $totalSold    = OrderItem::where('product_id', $product->id)
            ->join('orders','orders.id','=','order_items.order_id')
            ->whereIn('orders.status', ['delivered','shipped','preparing','confirmed'])
            ->sum('order_items.quantity');

        $totalRevenue = OrderItem::where('product_id', $product->id)
            ->join('orders','orders.id','=','order_items.order_id')
            ->whereIn('orders.status', ['delivered','shipped','preparing','confirmed'])
            ->sum('order_items.total');

        $totalOrders  = OrderItem::where('product_id', $product->id)
            ->join('orders','orders.id','=','order_items.order_id')
            ->whereIn('orders.status', ['delivered','shipped','preparing','confirmed'])
            ->distinct('order_id')->count('order_id');

        // Expiry batches
        $batches = $product->expiries()->orderBy('expiry_date')->get();

        // Recent orders containing this product
        $recentOrders = OrderItem::where('product_id', $product->id)
            ->with(['order.user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.products.analytics', compact(
            'product','salesByMonth','totalSold','totalRevenue','totalOrders','batches','recentOrders'
        ));
    }
}
