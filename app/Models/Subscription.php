<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model {
    protected $fillable = [
        'user_id','product_id','address_id','quantity',
        'frequency_days','next_order_date','started_at',
        'status','auto_renew','notes'
    ];
    protected $casts = ['next_order_date' => 'date', 'started_at' => 'date', 'auto_renew' => 'boolean'];

    public function user()    { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(Product::class); }
    public function address() { return $this->belongsTo(Address::class); }

    public function isActive() { return $this->status === 'active'; }
    public function isDueToday() {
        return $this->isActive() && $this->next_order_date->isToday();
    }
}
