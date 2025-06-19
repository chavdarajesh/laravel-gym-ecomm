<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('payment_method')->nullable();
            $table->string('reference_id')->nullable();
            $table->string('payment_date_time')->nullable();
            $table->string('attachment_path')->nullable();
            $table->boolean('is_verified')->default(0)->nullable();
            $table->string('request_status')->default('pending')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('shipping_charge')->nullable();
            $table->string('total_order')->nullable();
            $table->timestamps();
             $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_uploads');
    }
}
