<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PostStatus', function (Blueprint $table) {
            // $table->increments('post_id');
            // $table->string('programid',5)->primary();
            $table->string('post_id')->primary();
            $table->text('post_content');
            $table->uuid('post_user_id');
            $table->foreign('post_user_id')->references('user_id')->on('systemusers')->onDelete('cascade');
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
        Schema::dropIfExists('PostStatus');
    }
}
