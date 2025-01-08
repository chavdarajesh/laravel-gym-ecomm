<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'order_id',
        'status',
        'payment_id',
        'payment_method',
        'payment_token',
        'payer_email',
        'payer_name',
        'payer_id',
        'business_name',
        'account_id',
        'shipping_name',
        'shipping_address',
        'currency_code',
        'total_order',
        'sub_total',
        'shipping_charge',
        'paypal_fee',
        'net_amount',
        'exchange_rate',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

}
