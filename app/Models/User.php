<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'is_verified',
        'is_admin',
        'role',
        'phone',
        'username',
        'address',
        'dateofbirth',
        'image',
        'otp',
        'organization_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static public function get_user_by_id($id)
    {
        $User = [];
        $user = User::find($id);
        if ($user) {
            $User = $user;
        } else {
            $User['name'] = 'User Deleted';
        }
        return $User;
    }
    static public function get_total_use_referral_user_by_id($id)
    {
        if ($id) {
            $user_other_referral_code = User::where('other_referral_user_id', $id)->count();
            return $user_other_referral_code;
        } else {
            return 0;
        }
    }

    public function referredByUser()
    {
        return $this->belongsTo(User::class, 'other_referral_user_id');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'other_referral_user_id');
    }
}
