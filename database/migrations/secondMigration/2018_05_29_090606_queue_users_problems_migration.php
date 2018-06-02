<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QueueUsersProblemsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('QueueUsersProblems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('queueID');
            $table->foreign('queueID')->references('queueID')->on('queuetalkcircle')->onDelete('cascade');
            $table->string('problem_id');
            $table->foreign('problem_id')->references('problem_id')->on('problem')->onDelete('cascade');
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
        Schema::dropIfExists('QueueUsersProblems');
    }
}
