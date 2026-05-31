<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        'order_number','user_id','prescription_id','address_id',
        'subtotal','discount','delivery_fee','total',
        'status','payment_method','payment_status','notes','delivered_at'
    ];
    protected $casts = ['delivered_at' => 'datetime'];

    public function user()         { return $this->belongsTo(User::class); }
    public function items()        { return $this->hasMany(OrderItem::class); }
    public function prescription() { return $this->belongsTo(Prescription::class); }
    public function address()      { return $this->belongsTo(Address::class); }

    public static function generateNumber() {
        return 'PH-' . date('Ymd') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    public function getStatusLabelAttribute() {
        return match($this->status) {
            'pending'   => ['ar' => 'قيد المراجعة',   'en' => 'Pending'],
            'confirmed' => ['ar' => 'تم التأكيد',      'en' => 'Confirmed'],
            'preparing' => ['ar' => 'جاري التجهيز',    'en' => 'Preparing'],
            'shipped'   => ['ar' => 'في الطريق',        'en' => 'Shipped'],
            'delivered' => ['ar' => 'تم التسليم',       'en' => 'Delivered'],
            'cancelled' => ['ar' => 'ملغي',             'en' => 'Cancelled'],
            default     => ['ar' => $this->status,      'en' => $this->status],
        };
    }
}
