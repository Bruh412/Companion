<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VenueMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venue', function (Blueprint $table) {
            $table->increments('id');
            $table->text('venueName');
            $table->text('latitude');
            $table->text('longitude');
            $table->string('venueCategory');

            // $table->foreign('venueCategory')->references('id')->on('venuecategories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venue');
    }
}
