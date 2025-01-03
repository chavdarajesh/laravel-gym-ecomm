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
            $table->string('payment_id')->nullable();
            $table->string('total_order')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('shipping_charge')->nullable();
            $table->string('status')->nullable()->default('pending');
            $table->string('payment_type')->nullable()->default('paypal');
            $table->string('payment_status')->nullable()->default('pending');
            $table->string('order_status')->nullable()->default('pending');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
