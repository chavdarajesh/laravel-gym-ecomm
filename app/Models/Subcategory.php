<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use HasFactory;use SoftDeletes;
    protected $fillable = ['name', 'image', 'description'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_subcategories', 'subcategory_id', 'category_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function brandSubcategories()
    {
        return $this->belongsToMany(Brand::class, 'brand_subcategories', 'subcategory_id', 'brand_id');
    }
}
