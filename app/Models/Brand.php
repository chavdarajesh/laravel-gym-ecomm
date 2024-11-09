<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory;use SoftDeletes;

    protected $fillable = ['name', 'image', 'description'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'brand_categories');
    }

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'brand_subcategories');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
