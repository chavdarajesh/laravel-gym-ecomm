<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_mails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->unsignedBigInteger('newsletter_content_id')->nullable();
            $table->unsignedBigInteger('newsletter_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('newsletter_content_id')
              ->references('id')->on('newsletter_contents')
              ->onDelete('cascade');
              $table->foreign('newsletter_id')
              ->references('id')->on('newsletters')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_mails');
    }
}
