<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('static_id',[1]);
	        $table->string('email')->nullable();
	        $table->string('phone')->nullable();
	        $table->string('address_1')->nullable();
	        $table->string('address_2')->nullable();
	        $table->string('location')->nullable();
	        $table->text('map_iframe')->nullable();
	        $table->text('timing')->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_us_settings');
    }
}
