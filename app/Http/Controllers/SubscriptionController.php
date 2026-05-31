<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller {


    public function index() {
        $subscriptions = auth()->user()->subscriptions()->with('product')->latest()->get();
        return view('subscriptions.index', compact('subscriptions'));
    }

    public function store(Request $request) {
        $request->validate([
            'product_id'     => 'required|exists:products,id',
            'quantity'       => 'required|integer|min:1',
            'frequency_days' => 'required|integer|in:7,14,30,60,90',
            'address_id'     => 'required|exists:addresses,id',
        ]);

        Subscription::create([
            'user_id'         => auth()->id(),
            'product_id'      => $request->product_id,
            'address_id'      => $request->address_id,
            'quantity'        => $request->quantity,
            'frequency_days'  => $request->frequency_days,
            'next_order_date' => now()->addDays($request->frequency_days),
            'started_at'      => now(),
        ]);

        return back()->with('success', app()->getLocale() === 'ar' ? 'تم إنشاء الاشتراك بنجاح' : 'Subscription created successfully');
    }

    public function toggle(Subscription $subscription) {
        abort_if($subscription->user_id !== auth()->id(), 403);
        $subscription->update([
            'status' => $subscription->status === 'active' ? 'paused' : 'active'
        ]);
        return back();
    }

    public function destroy(Subscription $subscription) {
        abort_if($subscription->user_id !== auth()->id(), 403);
        $subscription->update(['status' => 'cancelled']);
        return back()->with('success', 'Subscription cancelled');
    }
}
