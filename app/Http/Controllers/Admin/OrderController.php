<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {


    public function index(Request $request) {
        $query = Order::with('user')->latest();
        if ($request->status) $query->where('status', $request->status);
        if ($request->q) {
            $q = $request->q;
            $query->where(function($sq) use ($q) {
                $sq->where('order_number','like',"%$q%")
                   ->orWhereHas('user', fn($u) => $u->where('name','like',"%$q%")->orWhere('phone','like',"%$q%"));
            });
        }
        $orders = $query->paginate(20)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order) {
        $order->load('items.product','user','address','prescription');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order) {
        $request->validate(['status' => 'required|in:pending,confirmed,preparing,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        if ($request->status === 'delivered') $order->update(['delivered_at' => now()]);
        return back()->with('success','Status updated');
    }
}
