<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activityproblem', function (Blueprint $table) {
            $table->increments('id');
            $table->string('problem_id');
            $table->string('actID');

            $table->foreign('problem_id')->references('problem_id')->on('problem')->onDelete('cascade');
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
        Schema::dropIfExists('activityproblem');
    }
}
