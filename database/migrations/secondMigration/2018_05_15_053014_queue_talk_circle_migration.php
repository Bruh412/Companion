<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QueueTalkCircleMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queueTalkCircle', function (Blueprint $table) {
            // $table->increments('id');
            // $table->timestamps();
            $table->string('queueID')->primary();
            $table->string('user_id');

            $table->foreign('user_id')->references('user_id')->on('systemusers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queueTalkCircle');
    }
}
