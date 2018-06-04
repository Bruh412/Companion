<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopCategoriesForPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_categories_for_posts', function (Blueprint $table) {
            $table->string('top_id')->primary();
            $table->string('post_id');
            $table->foreign('post_id')->references('post_id')->on('poststatus')->onDelete('cascade');
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
        Schema::dropIfExists('top_categories_for_posts');
    }
}
