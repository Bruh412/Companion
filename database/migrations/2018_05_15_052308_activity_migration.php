<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivityMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->string('actID')->primary();
            $table->string('title')->unique();
            $table->text('details');
            $table->integer('participants');
            // $table->string('equipment',255);
            $table->string('time',20);
            $table->string('gender',20);

            // $table->integer('filesID',255);
            //$table->text('embed')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
