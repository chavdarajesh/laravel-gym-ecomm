<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'price',
        'user_id',
        'payment_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'total_order',
        'sub_total',
        'shipping_charge',
        'payment_type',
    ];





    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('quantity', 'price', 'user_id', 'size_id', 'flavor_id', 'total_price');
    }

    public function statuses()
    {
        return $this->belongsToMany(OrderStatus::class, 'order_status_pivots', 'order_id', 'status_id')
            ->withPivot('description')->withTimestamps();;
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
