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
        abort_unless($order->user_id === auth()->id(), 403);
        $order->load('items.product','address','prescription');
        return view('account.order', compact('order'));
    }

    public function addresses() {
        $addresses = auth()->user()->addresses()->get();
        return view('account.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request) {
        $data = $request->validate([
            'label'          => 'required|string|max:50',
            'recipient_name' => 'required|string|max:200',
            'phone'          => 'required|string|max:20',
            'city'           => 'required|string|max:100',
            'street'         => 'required|string|max:300',
            'area'           => 'nullable|string|max:100',
            'is_default'     => 'boolean',
        ]);
        $data['user_id'] = auth()->id();
        if ($request->is_default) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }
        Address::create($data);
        return back()->with('success', app()->getLocale()==='ar' ? 'تم حفظ العنوان' : 'Address saved');
    }

    // Repeat Order
    public function reorder(Order $order) {
        abort_unless($order->user_id === auth()->id(), 403);
        $cart = session()->get('cart', []);
        foreach ($order->items as $item) {
            if ($item->product && $item->product->is_active && $item->product->stock > 0) {
                $cart[$item->product_id] = ['qty' => ($cart[$item->product_id]['qty'] ?? 0) + $item->quantity];
            }
        }
        session()->put('cart', $cart);
        return redirect()->route('cart')->with('success',
            app()->getLocale()==='ar' ? 'تمت إضافة المنتجات للسلة' : 'Items added to cart');
    }

    public function setLang($lang) {
        if (in_array($lang, ['ar','en'])) {
            session()->put('locale', $lang);
            if (auth()->check()) {
                auth()->user()->update(['preferred_lang' => $lang]);
            }
        }
        return back();
    }

    // Dark mode toggle
    public function toggleTheme(Request $request) {
        $theme = $request->theme === 'dark' ? 'dark' : 'light';
        session()->put('theme', $theme);
        return response()->json(['theme' => $theme]);
    }
}
