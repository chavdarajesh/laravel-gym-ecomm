<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
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
        OrderStatus::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $statuses = [
            ['name' => 'Pending', 'description' => 'Order has been placed but not yet processed.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Processing', 'description' => 'Order is currently being processed.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Shipped', 'description' => 'Order has been shipped.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Delivered', 'description' => 'Order has been delivered.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Completed', 'description' => 'Order has been completed and delivered.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cancelled', 'description' => 'Order has been cancelled.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Refunded', 'description' => 'Order has been refunded.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Failed', 'description' => 'Order has failed.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cancelled By User', 'description' => 'Order has been cancelled by the user.', 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('order_statuses')->insert($statuses);
    }
}
