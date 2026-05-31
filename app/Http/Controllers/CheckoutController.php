<?php
namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller {

    public function index() {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart');

        $items = []; $subtotal = 0; $needsPrescription = false;
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $lineTotal = $product->current_price * $item['qty'];
                $subtotal += $lineTotal;
                $items[] = ['product' => $product, 'qty' => $item['qty'], 'subtotal' => $lineTotal];
                if ($product->requires_prescription) $needsPrescription = true;
            }
        }

        $deliveryFee   = $subtotal >= 200 ? 0 : 25;
        $total         = $subtotal + $deliveryFee;
        $addresses     = auth()->user()->addresses()->get();
        $prescriptions = $needsPrescription
            ? auth()->user()->prescriptions()->where('status','approved')->latest()->get()
            : collect();

        return view('checkout.index', compact('items','subtotal','deliveryFee','total','addresses','needsPrescription','prescriptions'));
    }

    public function store(Request $request) {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart');

        // Determine address_id
        $addressId = $request->address_id;

        // If no saved address selected, use manual fields
        if (!$addressId) {
            $request->validate([
                'recipient_name' => 'required|string|max:200',
                'phone'          => 'required|string|max:20',
                'city'           => 'required|string|max:100',
                'street'         => 'required|string|max:300',
                'payment_method' => 'required|in:cod,card,wallet',
            ]);

            // Save address if requested
            if ($request->save_address) {
                $addr = Address::create([
                    'user_id'        => auth()->id(),
                    'label'          => app()->getLocale()==='ar' ? 'عنوان جديد' : 'New Address',
                    'recipient_name' => $request->recipient_name,
                    'phone'          => $request->phone,
                    'city'           => $request->city,
                    'street'         => $request->street,
                    'area'           => $request->area,
                    'is_default'     => auth()->user()->addresses()->count() === 0,
                ]);
                $addressId = $addr->id;
            }
        } else {
            $request->validate(['payment_method' => 'required|in:cod,card,wallet']);
            // Make sure address belongs to user
            abort_unless(auth()->user()->addresses()->where('id',$addressId)->exists(), 403);
        }

        DB::transaction(function() use ($request, $cart, $addressId) {
            $subtotal = 0; $items = [];
            foreach ($cart as $id => $item) {
                $product   = Product::lockForUpdate()->findOrFail($id);
                $lineTotal = $product->current_price * $item['qty'];
                $subtotal += $lineTotal;
                $items[]   = ['product' => $product, 'qty' => $item['qty'], 'price' => $product->current_price, 'total' => $lineTotal];
                $product->decrement('stock', $item['qty']);
            }

            $deliveryFee = $subtotal >= 200 ? 0 : 25;
            $order = Order::create([
                'order_number'    => Order::generateNumber(),
                'user_id'         => auth()->id(),
                'prescription_id' => $request->prescription_id,
                'address_id'      => $addressId,
                'subtotal'        => $subtotal,
                'delivery_fee'    => $deliveryFee,
                'total'           => $subtotal + $deliveryFee,
                'payment_method'  => $request->payment_method,
                'notes'           => $request->notes,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product']->id,
                    'quantity'   => $item['qty'],
                    'price'      => $item['price'],
                    'total'      => $item['total'],
                ]);
            }

            session()->forget('cart');
            session()->put('last_order_id', $order->id);
        });

        return redirect()->route('checkout.success');
    }

    public function success() {
        $orderId = session()->get('last_order_id');
        $order   = $orderId ? Order::with('items.product')->find($orderId) : null;
        return view('checkout.success', compact('order'));
    }
}
