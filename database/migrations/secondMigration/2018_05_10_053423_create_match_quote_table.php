<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchQuoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MatchQuote', function (Blueprint $table) {
            // $table->increments('id');
            $table->string('categoryID');
            $table->foreign('categoryID')->references('categoryID')->on('categories')->onDelete('cascade');
            $table->string('quoteID');
            $table->foreign('quoteID')->references('quoteID')->on('quotes')->onDelete('cascade');
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
        Schema::dropIfExists('MatchQuote');
    }
}
