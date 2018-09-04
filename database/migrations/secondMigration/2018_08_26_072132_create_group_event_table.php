<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_event', function (Blueprint $table) {
            $table->increments('id');
            $table->string('eventLoc_id');
            $table->string('eventAct_id');
            $table->string('event_detailsID');
            $table->string('event_memberID');

            $table->foreign('eventLoc_id')->references('eventLoc_id')->on('event_location')->onDelete('cascade');
            $table->foreign('eventAct_id')->references('eventAct_id')->on('event_activities')->onDelete('cascade');
            $table->foreign('event_detailsID')->references('event_detailsID')->on('event_details')->onDelete('cascade');
            $table->foreign('event_memberID')->references('event_memberID')->on('event_members')->onDelete('cascade');
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
