<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_status_pivots', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('order_id')->nullable();
        $table->unsignedBigInteger('status_id')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        $table->foreign('status_id')->references('id')->on('order_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_status_pivots');
    }
}
