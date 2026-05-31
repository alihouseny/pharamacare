<?php
namespace App\Http\Controllers;

use App\Models\DrugInteraction;
use App\Models\Product;
use Illuminate\Http\Request;

class InteractionController extends Controller {

    // Check interactions for cart items
    public function checkCart() {
        $cart        = session()->get('cart', []);
        $productIds  = array_keys($cart);
        $ingredients = Product::whereIn('id', $productIds)
            ->whereNotNull('active_ingredient')
            ->pluck('active_ingredient')
            ->map(fn($i) => strtolower(trim($i)))
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $interactions = DrugInteraction::checkIngredients($ingredients);

        return response()->json([
            'has_interactions' => $interactions->count() > 0,
            'interactions'     => $interactions->map(fn($i) => [
                'severity'    => $i->severity,
                'description' => $i->description,
                'ingredient_a'=> $i->ingredient_a,
                'ingredient_b'=> $i->ingredient_b,
            ])
        ]);
    }

    // Check two specific products
    public function checkProducts(Request $request) {
        $ids = $request->product_ids ?? [];
        if (count($ids) < 2) return response()->json(['has_interactions' => false, 'interactions' => []]);

        $ingredients = Product::whereIn('id', $ids)
            ->whereNotNull('active_ingredient')
            ->pluck('active_ingredient')
            ->map(fn($i) => strtolower(trim($i)))
            ->filter()->unique()->values()->toArray();

        $interactions = DrugInteraction::checkIngredients($ingredients);

        return response()->json([
            'has_interactions' => $interactions->count() > 0,
            'interactions'     => $interactions->map(fn($i) => [
                'severity'    => $i->severity,
                'description' => $i->description,
                'ingredient_a'=> $i->ingredient_a,
                'ingredient_b'=> $i->ingredient_b,
            ])
        ]);
    }

    // Admin CRUD
    public function index() {
        $interactions = DrugInteraction::orderBy('severity')->paginate(20);
        return view('admin.interactions.index', compact('interactions'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'ingredient_a'   => 'required|string|max:200',
            'ingredient_b'   => 'required|string|max:200',
            'severity'       => 'required|in:mild,moderate,severe',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
        ]);
        DrugInteraction::create($data);
        return back()->with('success', app()->getLocale()==='ar' ? 'تم الإضافة' : 'Added');
    }

    public function destroy(DrugInteraction $interaction) {
        $interaction->delete();
        return back()->with('success', app()->getLocale()==='ar' ? 'تم الحذف' : 'Deleted');
    }
}
