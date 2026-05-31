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

    public function isAdmin()       { return $this->role === 'admin'; }
    public function isPharmacist()  { return in_array($this->role, ['admin','pharmacist']); }
}
