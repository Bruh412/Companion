<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MatchVideo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('videoID');
            $table->foreign('videoID')->references('videoID')->on('youtubevideo')->onDelete('cascade');
            $table->string('categoryID');
            $table->foreign('categoryID')->references('categoryID')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MatchVideo');
    }
}
