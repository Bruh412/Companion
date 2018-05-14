<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersPostFeelings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UsersPostFeelings', function (Blueprint $table) {
            // $table->increments('id');
            $table->string('post_id');
            $table->foreign('post_id')->references('post_id')->on('poststatus')->onDelete('cascade');
            $table->string('post_feeling_id');
            $table->foreign('post_feeling_id')->references('post_feeling_id')->on('postfeelings')->onDelete('cascade');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('UsersPostFeelings');
    }
}
