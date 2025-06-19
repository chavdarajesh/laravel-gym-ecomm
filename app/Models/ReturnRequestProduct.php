<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequestProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_request_id',
        'order_id',
        'user_id',
        'product_id',
        'quantity',
        'price',
        'total_price',
        'size_id',
        'flavor_id',
    ];

    // Relationships
    public function returnRequest()
    {
        return $this->belongsTo(ReturnRequest::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function flavor()
    {
        return $this->belongsTo(Flavor::class, 'flavor_id');
    }
}
