<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SurveryAnswersMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveyanswers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('questionBasis');
            $table->text('answer');
            $table->integer('owner');
            $table->integer('event');
            
            // $table->foreign('questionBasis')->references('id')->on('paequestions');
            // $table->foreign('owner')->references('user_id')->on('systemusers');
            // $table->foreign('event')->references('id')->on('event');

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
        Schema::dropIfExists('surveyanswers');
    }
}
