<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFlavor extends Model
{
    use HasFactory;use SoftDeletes;
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function flavor()
    {
        return $this->belongsTo(Flavor::class);
    }
}
