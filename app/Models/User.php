<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;
    protected $fillable = ['name','email','phone','password','role','avatar','is_active','preferred_lang'];
    protected $hidden   = ['password','remember_token'];
    protected $casts    = ['is_active' => 'boolean'];

    public function orders()        { return $this->hasMany(Order::class); }
    public function prescriptions() { return $this->hasMany(Prescription::class); }
    public function subscriptions() { return $this->hasMany(Subscription::class); }
    public function addresses()     { return $this->hasMany(Address::class); }
    public function defaultAddress(){ return $this->hasOne(Address::class)->where('is_default', true); }
    public function wishlist()      { return $this->hasMany(Wishlist::class); }
    public function reviews()       { return $this->hasMany(ProductReview::class); }

    public function isAdmin()      { return $this->role === 'admin'; }
    public function isPharmacist() { return in_array($this->role, ['admin','pharmacist']); }

    public function getSegmentAttribute() {
        $orderCount = $this->orders()->whereIn('status',['delivered'])->count();
        $totalSpent = $this->orders()->whereIn('status',['delivered'])->sum('total');
        if ($orderCount >= 10 || $totalSpent >= 5000) return ['ar'=>'VIP 👑','en'=>'VIP 👑','color'=>'#F9A825'];
        if ($orderCount >= 3)  return ['ar'=>'منتظم ⭐','en'=>'Regular ⭐','color'=>'var(--primary)'];
        if ($orderCount >= 1)  return ['ar'=>'نشط','en'=>'Active','color'=>'var(--success)'];
        return ['ar'=>'جديد','en'=>'New','color'=>'var(--text-muted)'];
    }
}
