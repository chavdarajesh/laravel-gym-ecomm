<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUsSetting extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'map_iframe',
        'address_1',
        'address_2',
        'email',
        'phone',
        'timing',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function get_contact_us_details()
    {
        return ContactUsSetting::where('static_id', 1)->where('status', 1)->first();
    }

}
