<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostFeelings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PostFeelings', function (Blueprint $table) {
            // $table->increments('id');
            // $table->timestamps();
            $table->string('post_feeling_id')->primary();
            $table->string('post_feeling_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PostFeelings');
    }
}
