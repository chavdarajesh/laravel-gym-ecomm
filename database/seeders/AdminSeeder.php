<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin@123'),
            'phone' => 9876543210,
            'address' => 'test test address',
            'dateofbirth' => '2022-06-15',
            'status' => 1,
            'is_verified' => 1,
            'created_at'=>Carbon::now('Asia/Kolkata'),
            'otp'=> null,
            'role'=> 'admin',
            'is_admin'=>1,
            'is_user'=>0,
            'email_verified_at'=>Carbon::now('Asia/Kolkata'),
            'referral_code'=>Str::slug('admin@gmail.com', "-"),
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('User@123'),
            'phone' => 1234567890,
            'address' => 'test test address',
            'dateofbirth' => '2022-06-15',
            'status' => 1,
            'is_verified' => 1,
            'created_at'=>Carbon::now('Asia/Kolkata'),
            'otp'=> null,
            'role'=> 'user',
            'is_admin'=>0,
            'is_user'=>1,
            'email_verified_at'=>Carbon::now('Asia/Kolkata'),
            'referral_code'=>Str::slug('user@gmail.com', "-"),
        ]);
    }
}
