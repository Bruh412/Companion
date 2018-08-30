<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupmembers', function (Blueprint $table) {
            // $table->increments('id');
            // $table->timestamps();

            $table->string('groupMemberID')->primary();
            $table->string('memberID');
            $table->string('fname');
            $table->string('lname');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('groupID');

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
        Schema::dropIfExists('groupmembers');
    }
}
