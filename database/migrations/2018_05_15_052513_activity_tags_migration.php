<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivityTagsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activityTags', function (Blueprint $table) {
            // $table->increments('id');
            // $table->timestamps();

            $table->increments('id');
            $table->string('tagID');
            $table->string('actID');

            $table->foreign('tagID')->references('interestID')->on('interests');
            $table->foreign('actID')->references('actID')->on('activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activityTags');
    }
}
