<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnRequestProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_request_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('return_request_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Optional for guest users
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->unsignedBigInteger('flavor_id')->nullable();
            $table->integer('quantity')->nullable()->default(1); // Optional
            $table->string('price')->nullable();
            $table->string('total_price')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreign('flavor_id')->references('id')->on('flavors')->onDelete('cascade');
            $table->foreign('return_request_id')->references('id')->on('return_requests')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_request_products');
    }
}
