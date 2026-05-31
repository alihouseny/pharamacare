<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model {
    protected $fillable = ['user_id','image','status','notes','pharmacist_notes','reviewed_by','reviewed_at'];
    protected $casts    = ['reviewed_at' => 'datetime'];

    public function user()     { return $this->belongsTo(User::class); }
    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by'); }
    public function orders()   { return $this->hasMany(Order::class); }

    public function isPending()  { return $this->status === 'pending'; }
    public function isApproved() { return $this->status === 'approved'; }
}
