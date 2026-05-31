<?php
namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;

class AccountController extends Controller {


    public function dashboard() {
        $orders        = auth()->user()->orders()->latest()->limit(5)->get();
        $subscriptions = auth()->user()->subscriptions()->where('status','active')->count();
        $prescriptions = auth()->user()->prescriptions()->count();
        return view('account.dashboard', compact('orders','subscriptions','prescriptions'));
    }

    public function orders() {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(10);
        return view('account.orders', compact('orders'));
    }

    public function order(Order $order) {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('items.product', 'address', 'prescription');
        return view('account.order', compact('order'));
    }

    public function addresses() {
        $addresses = auth()->user()->addresses()->get();
        return view('account.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request) {
        $request->validate([
            'label'          => 'required|string|max:50',
            'recipient_name' => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'street'         => 'required|string',
            'city'           => 'required|string|max:100',
        ]);

        if ($request->is_default) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        auth()->user()->addresses()->create($request->all());
        return back()->with('success', 'Address saved');
    }

    public function setLang($lang) {
        if (in_array($lang, ['ar','en'])) {
            session()->put('locale', $lang);
            auth()->user()?->update(['preferred_lang' => $lang]);
        }
        return back();
    }
}
