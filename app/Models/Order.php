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
        'order_id',
        'user_id',
        'payment_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'total_order',
        'sub_total',
        'shipping_charge',
        'payment_type',
        'order_address_id',
        'payment_status',
        'order_status',
        'return_status',
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
            ->withPivot('description', 'created_at')->withTimestamps();
    }

    // public function payments()
    // {
    //     return $this->hasMany(Payment::class, 'order_id');
    // }

    public function address()
    {
        return $this->belongsTo(OrderAddress::class, 'order_address_id');
    }

    public function latestStatus()
    {
        return $this->statuses()->orderBy('order_status_pivots.updated_at', 'desc')->limit(1);
    }

    public function paymentUploads()
    {
        return $this->hasMany(PaymentUpload::class);
    }

    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class);
    }

}
