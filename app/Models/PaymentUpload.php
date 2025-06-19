<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentUpload extends Model
{
    use HasFactory;use SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_id',
        'reference_id',
        'payment_date_time',
        'attachment_path',
        'payment_method',
        'is_verified',
        'request_status',
        'sub_total',
        'shipping_charge',
        'total_order',
        'created_at',
        'updated_at',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
