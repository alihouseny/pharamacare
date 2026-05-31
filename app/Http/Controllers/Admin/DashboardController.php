<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductExpiry;
use App\Models\User;
use App\Models\Prescription;

class DashboardController extends Controller {

    public function index() {
        $stats = [
            'total_orders'    => Order::count(),
            'today_orders'    => Order::whereDate('created_at', today())->count(),
            'total_revenue'   => Order::where('status','delivered')->sum('total'),
            'pending_orders'  => Order::where('status','pending')->count(),
            'total_products'  => Product::where('is_active', true)->count(),
            'low_stock'       => Product::where('stock', '<=', 10)->count(),
            'total_customers' => User::where('role','customer')->count(),
            'pending_rx'      => Prescription::where('status','pending')->count(),
        ];

        $expiringSoon = ProductExpiry::with('product')
            ->where('expiry_date', '<=', now()->addDays(90))
            ->where('expiry_date', '>=', now())
            ->where('remaining_quantity', '>', 0)
            ->orderBy('expiry_date')
            ->limit(10)
            ->get();

        $recentOrders = Order::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard.index', compact('stats', 'expiringSoon', 'recentOrders'));
    }
}
