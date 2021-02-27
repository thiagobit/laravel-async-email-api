<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_id')->nullable(false);
            $table->string('file_name')->nullable(false);
            $table->string('file_path')->nullable(false);

            $table->foreign('email_id')->references('id')->on('emails');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_attachments');
    }
}
