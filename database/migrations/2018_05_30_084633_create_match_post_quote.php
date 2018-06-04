<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchPostQuote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MatchPostQuote', function (Blueprint $table) {
            // $table->increments('id');
            // $table->timestamps();
            $table->string('matchID')->primary();
            $table->string('post_id');
            $table->foreign('post_id')->references('post_id')->on('poststatus')->onDelete('cascade');
            $table->string('quoteID');
            $table->foreign('quoteID')->references('quoteID')->on('quotes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MatchPostQuote');
    }
}
