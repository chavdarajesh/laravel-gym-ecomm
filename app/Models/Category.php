<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;use SoftDeletes;

    protected $fillable = ['name', 'image', 'description'];

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class,'category_subcategories');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class,'brand_categories');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function brandCategories()
    {
        return $this->belongsToMany(Brand::class, 'brand_categories', 'category_id', 'brand_id');
    }
}
