<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CommentPost', function (Blueprint $table) {
            $table->string('commentID')->primary();
            $table->text('comment_content');
            $table->string('post_id');
            $table->foreign('post_id')->references('post_id')->on('poststatus')->onDelete('cascade');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('user_id')->on('systemusers')->onDelete('cascade');
            // $table->string('commentID_fk')->nullable();
            // $table->foreign('commentID_fk')->references('commentID')->on('commentpost')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CommentPost');
    }
}
