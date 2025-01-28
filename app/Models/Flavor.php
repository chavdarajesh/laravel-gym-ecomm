<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flavor extends Model
{
    use HasFactory;use SoftDeletes;
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_flavors');
    }

    static public function get_flavor_by_id($id)
    {
        $Flavor = [];
        $flavor = Flavor::find($id);
        if ($flavor) {
            $Flavor = $flavor;
        } else {
            $Flavor['name'] = 'Flavor Deleted';
        }
        return $Flavor;
    }
}
