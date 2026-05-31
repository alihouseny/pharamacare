<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DrugInteraction extends Model {
    protected $fillable = ['ingredient_a','ingredient_b','severity','description_ar','description_en'];

    public function getDescriptionAttribute() {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    // Check interactions for a list of ingredients
    public static function checkIngredients(array $ingredients): \Illuminate\Support\Collection {
        if (count($ingredients) < 2) return collect();
        return static::where(function($q) use ($ingredients) {
            foreach ($ingredients as $a) {
                foreach ($ingredients as $b) {
                    if ($a !== $b) {
                        $q->orWhere(function($sq) use ($a, $b) {
                            $sq->whereRaw('LOWER(ingredient_a) = ?', [strtolower($a)])
                               ->whereRaw('LOWER(ingredient_b) = ?', [strtolower($b)]);
                        });
                    }
                }
            }
        })->get();
    }
}
