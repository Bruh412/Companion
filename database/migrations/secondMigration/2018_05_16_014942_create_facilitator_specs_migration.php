<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilitatorSpecsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilitatorspecs', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->foreign('user_id')->references('user_id')->on('systemusers')->onDelete('cascade');
            $table->string('spec_id');
            $table->foreign('spec_id')->references('spec_id')->on('specialization')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilitatorspecs');
    }
}
