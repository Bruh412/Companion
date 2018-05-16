<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilitatorPRCMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilitatorPRC', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->foreign('user_id')->references('user_id')->on('systemusers')->onDelete('cascade');
            $table->string('prc_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilitatorPRC');
    }
}
