<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    protected $fillable = ['name_ar','name_en','slug','parent_id','icon','image','sort_order','is_active'];
    protected $casts    = ['is_active' => 'boolean'];

    public function parent()   { return $this->belongsTo(Category::class, 'parent_id'); }
    public function children() { return $this->hasMany(Category::class, 'parent_id'); }
    public function products() { return $this->hasMany(Product::class); }

    public function getNameAttribute() {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }
}
