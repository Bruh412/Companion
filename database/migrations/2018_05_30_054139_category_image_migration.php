<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoryImageMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CategoryImage', function (Blueprint $table) {
            // $table->increments('id');
            $table->string('catImageID')->primary();
            $table->text('imageContent');
            $table->string('categoryID');

            $table->foreign('categoryID')->references('categoryID')->on('categories');
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
        Schema::dropIfExists('CategoryImage');
    }
}
