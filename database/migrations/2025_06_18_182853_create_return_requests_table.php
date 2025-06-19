<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('reference_id')->nullable();
            $table->string('photo_proof')->nullable();
            $table->string('return_date_time')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_account_holder_name')->nullable();
            $table->boolean('is_verified')->default(0)->nullable();
            $table->string('request_status')->default('pending')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('shipping_charge')->nullable();
            $table->string('total_order')->nullable();
            $table->text('return_reason')->nullable();
            $table->text('return_address')->nullable();
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
        Schema::dropIfExists('return_requests');
    }
}
