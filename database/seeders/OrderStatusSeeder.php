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
        OrderStatus::truncate();
        $statuses = [
            ['name' => 'Pending', 'description' => 'Order has been placed but not yet processed.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Processing', 'description' => 'Order is currently being processed.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Completed', 'description' => 'Order has been completed and delivered.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cancelled', 'description' => 'Order has been cancelled.', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('order_statuses')->insert($statuses);
    }
}
