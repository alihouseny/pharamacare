<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller {

    private function getCart() {
        return session()->get('cart', []);
    }

    private function cartData() {
        $cart  = $this->getCart();
        $items = [];
        $total = 0;
        $count = 0;
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $price    = $product->current_price;
                $subtotal = $price * $item['qty'];
                $total   += $subtotal;
                $count   += $item['qty'];
                $items[]  = [
                    'id'       => $product->id,
                    'name'     => $product->name,
                    'slug'     => $product->slug,
                    'image'    => $product->image ? asset('storage/'.$product->image) : null,
                    'price'    => $price,
                    'qty'      => $item['qty'],
                    'subtotal' => $subtotal,
                ];
            }
        }
        return compact('items', 'total', 'count');
    }

    public function index() {
        $data = $this->cartData();
        // for full cart page, re-attach product objects
        $cart  = $this->getCart();
        $items = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $subtotal = $product->current_price * $item['qty'];
                $total   += $subtotal;
                $items[]  = ['product' => $product, 'qty' => $item['qty'], 'subtotal' => $subtotal];
            }
        }
        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request) {
        $product = Product::findOrFail($request->product_id);
        if ($product->stock < 1) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => __('main.out_of_stock')]);
            }
            return back()->with('error', __('main.out_of_stock'));
        }
        $cart = $this->getCart();
        $qty  = $cart[$product->id]['qty'] ?? 0;
        $cart[$product->id] = ['qty' => $qty + ($request->qty ?? 1)];
        session()->put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(array_merge(['success' => true], $this->cartData()));
        }
        return back()->with('success', __('main.success'));
    }

    public function update(Request $request, $id) {
        $cart = $this->getCart();
        if (isset($cart[$id])) {
            if ($request->qty < 1) { unset($cart[$id]); }
            else { $cart[$id]['qty'] = (int)$request->qty; }
        }
        session()->put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(array_merge(['success' => true], $this->cartData()));
        }
        return back();
    }

    public function remove(Request $request, $id) {
        $cart = $this->getCart();
        unset($cart[$id]);
        session()->put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(array_merge(['success' => true], $this->cartData()));
        }
        return back()->with('success', 'Removed');
    }

    public function sidebar() {
        return response()->json($this->cartData());
    }

    public function count() {
        $cart = $this->getCart();
        return response()->json(['count' => array_sum(array_column($cart, 'qty'))]);
    }
}
