<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavedMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savedmedia', function (Blueprint $table) {
            $table->string('saved_media_id')->primary();
            $table->string('media_id');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('user_id')->on('systemusers')->onDelete('cascade');
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
        Schema::table('savedmedia', function (Blueprint $table) {
            //
        });
    }
}
