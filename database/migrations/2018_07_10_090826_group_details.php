<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupdetails', function (Blueprint $table) {
            // $table->increments('id');
            // $table->timestamps();

            $table->string('groupDetailID')->primary();
            $table->string('problemID');
            $table->string('groupID');

            $table->foreign('problemID')->references('problem_id')->on('problem')->onDelete('cascade');
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
        Schema::dropIfExists('groupdetails');
    }
}
