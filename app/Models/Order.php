<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;use SoftDeletes;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('quantity', 'price');
    }

    public function statuses()
    {
        return $this->belongsToMany(OrderStatus::class, 'order_status_pivot')
            ->withPivot('description');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
