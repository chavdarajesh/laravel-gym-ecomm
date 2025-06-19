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
            [
                'name' => 'Order Created',
                'key' => 'order_created',
                'type' => 'order',
                'admin_visible' => 0,
                'description' => 'The order has been created in the system and is awaiting payment from the customer.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Order Placed',
                'key' => 'order_placed',
                'type' => 'order',
                'admin_visible' => 0,
                'description' => 'The customer has placed the order, but it has not yet started processing.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Order Processing',
                'key' => 'order_processing',
                'type' => 'order',
                'admin_visible' => 0,
                'description' => 'The order is currently being processed by the admin or fulfillment team.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Order Shipped',
                'key' => 'order_shipped',
                'type' => 'order',
                'admin_visible' => 1,
                'description' => 'The order has been shipped and is on its way to the customer.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Order Delivered',
                'key' => 'order_delivered',
                'type' => 'order',
                'admin_visible' => 1,
                'description' => 'The order has been delivered to the customer.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Order Failed',
                'key' => 'order_failed',
                'type' => 'order',
                'admin_visible' => 1,
                'description' => 'The order process has failed due to an issue in processing or fulfillment.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Order Cancelled',
                'key' => 'order_cancelled',
                'type' => 'order',
                'admin_visible' => 0,
                'description' => 'The order was cancelled by the customer or due to inactivity.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Order Cancelled By Admin',
                'key' => 'order_cancelled_by_admin',
                'type' => 'order',
                'admin_visible' => 1,
                'description' => 'The order was cancelled by an admin due to policy or operational reasons.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Return Requested',
                'key' => 'return_requested',
                'type' => 'return',
                'admin_visible' => 0,
                'description' => 'The customer has requested a return for the order or an item within the order.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Refund Processing',
                'key' => 'refund_processing',
                'type' => 'return',
                'admin_visible' => 0,
                'description' => 'The refund process has been initiated and is under review by the admin.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Order Refunded',
                'key' => 'order_refunded',
                'type' => 'return',
                'admin_visible' => 1,
                'description' => 'The refund for the order has been successfully processed and completed.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Order Returned',
                'key' => 'order_returned',
                'type' => 'return',
                'admin_visible' => 0,
                'description' => 'The returned item(s) have been received and the return process is complete.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Return Rejected',
                'key' => 'return_rejected',
                'type' => 'return',
                'admin_visible' => 0,
                'description' => 'The admin has reviewed and rejected the return request.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Refund Rejected',
                'key' => 'refund_rejected',
                'type' => 'refund',
                'admin_visible' => 0,
                'description' => 'The admin has reviewed and rejected the refund request for the order.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Payment Pending',
                'key' => 'payment_pending',
                'type' => 'payment',
                'admin_visible' => 0,
                'description' => 'The payment for the order is pending and has not been received yet.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Payment Processing',
                'key' => 'payment_processing',
                'type' => 'payment',
                'admin_visible' => 0,
                'description' => 'The payment is currently being processed through the payment gateway.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Payment Failed',
                'key' => 'payment_failed',
                'type' => 'payment',
                'admin_visible' => 0,
                'description' => 'The payment transaction has failed. The order will not proceed until payment is completed.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Payment Completed',
                'key' => 'payment_completed',
                'type' => 'payment',
                'admin_visible' => 0,
                'description' => 'The payment for the order has been successfully received.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('order_statuses')->insert($statuses);
    }
}
