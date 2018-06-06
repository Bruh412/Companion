<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SpecMatchProbMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specmatchprob', function (Blueprint $table) {
            $table->increments('id');

            $table->string('spec_id');
            $table->string('problem_id');

            $table->foreign('spec_id')->references('spec_id')->on('specialization')->onDelete('cascade');
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
        Schema::dropIfExists('specmatchprob');
    }
}
