<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('total_order')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('shipping_charge')->nullable();
            $table->string('payment_type')->nullable()->default('online');
            $table->string('payment_status')->nullable()->default('pending');
            $table->string('order_status')->nullable()->default('pending');
            $table->string('return_status')->nullable()->default('none');
            $table->string('refund_id')->nullable();

            $table->unsignedBigInteger('order_address_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_address_id')->references('id')->on('order_addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
