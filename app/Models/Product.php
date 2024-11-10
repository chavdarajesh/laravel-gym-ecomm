<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'cover_image',
        'description',
        'price',
        'brand_id',
        'category_id',
        'subcategory_id'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes')
            ->withPivot('price') // Specify the additional pivot attribute
            ->withTimestamps();  //
    }

    public function flavors()
    {
        return $this->belongsToMany(Flavor::class, 'product_flavors');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function topSelling()
    {
        return $this->hasOne(TopSellingProduct::class);
    }

    public function productSlider()
    {
        return $this->hasOne(ProductSlider::class);
    }
}
