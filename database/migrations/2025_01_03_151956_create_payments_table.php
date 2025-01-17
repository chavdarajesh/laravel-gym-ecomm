<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_from')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('payment_token')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('payer_name')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('business_name')->nullable();
            $table->string('account_id')->nullable();
            $table->string('shipping_name')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('total_order')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('shipping_charge')->nullable();
            $table->decimal('paypal_fee', 10, 2)->nullable();
            $table->decimal('net_amount', 10, 2)->nullable();
            $table->string('exchange_rate')->nullable();
            $table->string('capture_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
}
