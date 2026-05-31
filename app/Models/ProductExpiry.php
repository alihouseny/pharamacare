<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductExpiry extends Model {
    protected $table    = 'product_expiry';
    protected $fillable = ['product_id','batch_number','manufacture_date','expiry_date','quantity','remaining_quantity','status'];
    protected $casts    = ['expiry_date' => 'date', 'manufacture_date' => 'date'];

    public function product() { return $this->belongsTo(Product::class); }

    public function getDaysUntilExpiryAttribute() {
        return now()->diffInDays($this->expiry_date, false);
    }
    public function isNearExpiry() {
        return $this->days_until_expiry <= 90 && $this->days_until_expiry > 0;
    }
    public function isExpired() {
        return $this->days_until_expiry <= 0;
    }
}
