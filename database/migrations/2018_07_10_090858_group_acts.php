<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupActs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupactivities', function (Blueprint $table) {
            // $table->increments('id');
            // $table->timestamps();
            
            $table->string('groupActID')->primary();
            $table->string('actID');
            $table->string('groupID');

            $table->foreign('actID')->references('actID')->on('activities')->onDelete('cascade');
            $table->foreign('groupID')->references('groupID')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupactivities');
    }
}
