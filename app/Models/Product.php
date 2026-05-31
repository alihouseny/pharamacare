<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = [
        'name_ar','name_en','slug','category_id','description_ar','description_en',
        'active_ingredient','manufacturer','barcode','requires_prescription',
        'price','sale_price','stock','min_stock_alert','image','gallery',
        'dosage_form','strength','package_size','is_featured','is_active'
    ];
    protected $casts = [
        'requires_prescription' => 'boolean',
        'is_featured'           => 'boolean',
        'is_active'             => 'boolean',
        'gallery'               => 'array',
        'price'                 => 'decimal:2',
        'sale_price'            => 'decimal:2',
    ];

    public function category()    { return $this->belongsTo(Category::class); }
    public function expiries()    { return $this->hasMany(ProductExpiry::class); }
    public function orderItems()  { return $this->hasMany(OrderItem::class); }
    public function subscriptions(){ return $this->hasMany(Subscription::class); }

    public function getNameAttribute() {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }
    public function getDescriptionAttribute() {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }
    public function getCurrentPriceAttribute() {
        return $this->sale_price ?? $this->price;
    }
    public function isLowStock() {
        return $this->stock <= $this->min_stock_alert;
    }
    public function getNearestExpiryAttribute() {
        return $this->expiries()->where('status','active')->orderBy('expiry_date')->first();
    }
}
