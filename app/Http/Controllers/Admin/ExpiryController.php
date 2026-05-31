<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductExpiry;
use Illuminate\Http\Request;

class ExpiryController extends Controller {


    public function index(Request $request) {
        $query = ProductExpiry::with('product')
            ->where('remaining_quantity', '>', 0);

        $filter = $request->filter ?? 'all';

        if ($filter === 'expired') {
            $query->where('expiry_date', '<', now());
        } elseif ($filter === 'near') {
            $query->whereBetween('expiry_date', [now(), now()->addDays(90)]);
        } elseif ($filter === 'ok') {
            $query->where('expiry_date', '>', now()->addDays(90));
        }

        $batches = $query->orderBy('expiry_date')->paginate(30)->withQueryString();

        $summary = [
            'expired'    => ProductExpiry::where('expiry_date','<', now())->where('remaining_quantity','>',0)->count(),
            'near_expiry'=> ProductExpiry::whereBetween('expiry_date',[now(), now()->addDays(90)])->where('remaining_quantity','>',0)->count(),
            'ok'         => ProductExpiry::where('expiry_date','>',now()->addDays(90))->where('remaining_quantity','>',0)->count(),
        ];

        return view('admin.expiry.index', compact('batches','summary','filter'));
    }
}
