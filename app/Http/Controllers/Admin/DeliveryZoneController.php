<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryZone;
use Illuminate\Http\Request;

class DeliveryZoneController extends Controller {

    public function index() {
        $zones = DeliveryZone::all();
        return view('admin.delivery.index', compact('zones'));
    }

    public function update(Request $request, DeliveryZone $zone) {
        $data = $request->validate([
            'name_ar'                  => 'required|string',
            'name_en'                  => 'required|string',
            'delivery_fee'             => 'required|numeric|min:0',
            'free_delivery_threshold'  => 'required|numeric|min:0',
            'estimated_days'           => 'required|integer|min:1',
            'is_active'                => 'boolean',
            'cities'                   => 'nullable|string',
        ]);
        $data['cities']     = array_filter(array_map('trim', explode(',', $request->cities ?? '')));
        $data['is_active']  = $request->boolean('is_active');
        $zone->update($data);
        return back()->with('success', app()->getLocale()==='ar' ? 'تم التحديث' : 'Updated');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name_ar'                 => 'required|string',
            'name_en'                 => 'required|string',
            'delivery_fee'            => 'required|numeric|min:0',
            'free_delivery_threshold' => 'required|numeric|min:0',
            'estimated_days'          => 'required|integer|min:1',
            'cities'                  => 'nullable|string',
        ]);
        $data['cities'] = array_filter(array_map('trim', explode(',', $request->cities ?? '')));
        DeliveryZone::create($data);
        return back()->with('success', app()->getLocale()==='ar' ? 'تم الإضافة' : 'Added');
    }

    // AJAX - calculate fee for a city
    public function calculate(Request $request) {
        $zone     = DeliveryZone::findByCity($request->city ?? '');
        $subtotal = floatval($request->subtotal ?? 0);
        if (!$zone) return response()->json(['fee' => 25, 'zone' => null, 'days' => 2]);
        return response()->json([
            'fee'   => $zone->feeForOrder($subtotal),
            'zone'  => $zone->name,
            'days'  => $zone->estimated_days,
            'free_at' => $zone->free_delivery_threshold,
        ]);
    }
}
