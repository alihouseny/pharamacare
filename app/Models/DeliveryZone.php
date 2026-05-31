<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DeliveryZone extends Model {
    protected $fillable = ['name_ar','name_en','delivery_fee','free_delivery_threshold','estimated_days','is_active','cities'];
    protected $casts    = ['is_active' => 'boolean', 'cities' => 'array', 'delivery_fee' => 'decimal:2'];

    public function getNameAttribute() {
        return app()->getLocale()==='ar' ? $this->name_ar : $this->name_en;
    }

    public static function findByCity(string $city): ?self {
        $city = trim($city);
        return static::where('is_active', true)->get()
            ->first(function($zone) use ($city) {
                $cities = $zone->cities ?? [];
                foreach ($cities as $c) {
                    if (mb_strpos($city, $c) !== false || mb_strpos($c, $city) !== false) return true;
                }
                return false;
            }) ?? static::where('is_active', true)->orderByDesc('id')->first(); // fallback
    }

    public function feeForOrder(float $subtotal): float {
        return $subtotal >= $this->free_delivery_threshold ? 0 : (float)$this->delivery_fee;
    }
}
