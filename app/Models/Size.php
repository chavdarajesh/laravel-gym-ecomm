<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory;use SoftDeletes;
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sizes')
        ->withPivot('price','id')
        ->withTimestamps();
    }


    static public function get_size_by_id($id)
    {
        $Size = [];
        $size = Size::find($id);
        if ($size) {
            $Size = $size;
        } else {
            $Size['name'] = 'Size Deleted';
        }
        return $Size;
    }
}
