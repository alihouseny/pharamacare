<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller {

    public function index() {
        $from = request('from', now()->startOfMonth()->format('Y-m-d'));
        $to   = request('to', now()->format('Y-m-d'));

        $orders = Order::with('user','items.product')
            ->whereBetween('created_at', [$from, $to.' 23:59:59'])
            ->get();

        $stats = [
            'total_orders'   => $orders->count(),
            'delivered'      => $orders->where('status','delivered')->count(),
            'cancelled'      => $orders->where('status','cancelled')->count(),
            'total_revenue'  => $orders->whereIn('status',['delivered','shipped','preparing','confirmed'])->sum('total'),
            'avg_order'      => $orders->whereIn('status',['delivered','shipped','preparing','confirmed'])->avg('total'),
            'new_customers'  => User::whereBetween('created_at',[$from,$to.' 23:59:59'])->where('role','customer')->count(),
        ];

        // Top products in period
        $topProducts = OrderItem::with('product')
            ->join('orders','orders.id','=','order_items.order_id')
            ->whereBetween('orders.created_at',[$from,$to.' 23:59:59'])
            ->whereIn('orders.status',['delivered','shipped','preparing','confirmed'])
            ->selectRaw('product_id, SUM(quantity) as qty, SUM(order_items.total) as rev')
            ->groupBy('product_id')->orderByDesc('rev')->limit(10)->get();

        // Revenue by day
        $dailyRevenue = Order::whereBetween('created_at',[$from,$to.' 23:59:59'])
            ->whereIn('status',['delivered','shipped','preparing','confirmed'])
            ->selectRaw('DATE(created_at) as day, SUM(total) as revenue, COUNT(*) as orders')
            ->groupBy('day')->orderBy('day')->get();

        return view('admin.reports.index', compact('stats','orders','topProducts','dailyRevenue','from','to'));
    }

    // Export orders CSV
    public function exportCsv() {
        $from = request('from', now()->startOfMonth()->format('Y-m-d'));
        $to   = request('to', now()->format('Y-m-d'));

        $orders = Order::with('user','address')
            ->whereBetween('created_at',[$from,$to.' 23:59:59'])
            ->get();

        $filename = 'orders_'.$from.'_to_'.$to.'.csv';
        $headers  = ['Content-Type' => 'text/csv; charset=UTF-8', 'Content-Disposition' => 'attachment; filename="'.$filename.'"'];

        $callback = function() use ($orders) {
            $f = fopen('php://output','w');
            fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM for Excel
            fputcsv($f, ['رقم الطلب','العميل','الهاتف','العنوان','المبلغ','الحالة','طريقة الدفع','التاريخ']);
            foreach ($orders as $o) {
                fputcsv($f, [
                    $o->order_number,
                    $o->user->name,
                    $o->user->phone ?? $o->address?->phone ?? '',
                    $o->address ? $o->address->street.', '.$o->address->city : '',
                    $o->total,
                    $o->status_label['ar'],
                    $o->payment_method,
                    $o->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($f);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Generate Invoice HTML (printable)
    public function invoice(Order $order) {
        $order->load('items.product','user','address','prescription');
        return view('admin.reports.invoice', compact('order'));
    }

    // Low stock report
    public function lowStock() {
        $products = Product::where('is_active', true)
            ->whereColumn('stock','<=','min_stock_alert')
            ->with('category')
            ->orderBy('stock')
            ->get();
        return view('admin.reports.low_stock', compact('products'));
    }
}
