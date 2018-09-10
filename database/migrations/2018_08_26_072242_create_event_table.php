<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->string('event_id')->primary();
            $table->string('name');
            $table->string('description');
            $table->string('date');
            $table->string('timeStart');
            $table->string('timeEnd');
            $table->longText('picture')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('location_name');

            $table->string('event_groupID');
            $table->foreign('event_groupID')->references('event_groupID')->on('event_group')->onDelete('cascade');
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
