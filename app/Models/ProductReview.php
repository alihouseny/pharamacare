<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model {
    protected $fillable = ['product_id','user_id','order_id','rating','comment','is_approved'];
    protected $casts    = ['is_approved' => 'boolean'];

    public function product() { return $this->belongsTo(Product::class); }
    public function user()    { return $this->belongsTo(User::class); }
    public function order()   { return $this->belongsTo(Order::class); }

    public function stars() {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}
