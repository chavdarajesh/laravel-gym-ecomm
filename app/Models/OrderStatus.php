<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use HasFactory;use SoftDeletes;
    protected $fillable = ['name','description'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_status_pivots', 'status_id', 'order_id')
                    ->withPivot('description')->withTimestamps();;
    }
}
