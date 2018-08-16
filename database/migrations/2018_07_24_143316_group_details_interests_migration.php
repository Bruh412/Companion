<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupDetailsInterestsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupdetailsinterests', function (Blueprint $table) {
            // $table->increments('id');
            // $table->timestamps();

            $table->string('groupDetailID')->primary();
            $table->string('interestID');
            $table->string('groupID');

            $table->foreign('interestID')->references('interestID')->on('interests')->onDelete('cascade');
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
        Schema::dropIfExists('groupdetailsinterests');
    }
}
