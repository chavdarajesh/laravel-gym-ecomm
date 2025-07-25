<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnRequest extends Model
{
    use HasFactory;use SoftDeletes;

     protected $fillable = [
        'order_id',
        'user_id',
        'reference_id',
        'photo_proof',
        'return_date_time',
        'bank_account_name',
        'bsb_number',
        'account_no',
        'account_holder_name',
        'is_verified',
        'request_status',
        'sub_total',
        'shipping_charge',
        'total_order',
        'return_reason',
        'return_address',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

   public function products()
{
    return $this->hasMany(ReturnRequestProduct::class, 'return_request_id');
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function order()
{
    return $this->belongsTo(Order::class);
}

}
