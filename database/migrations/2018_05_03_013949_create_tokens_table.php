<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tokens', function (Blueprint $table) {
            $table->string('token_id')->primary();
            $table->uuid('token');
            $table->uuid('token_user_id');
            $table->foreign('token_user_id')->references('user_id')->on('systemusers')->onDelete('cascade');
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
        Schema::dropIfExists('Tokens');
    }
}
