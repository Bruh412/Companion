<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SystemConfigMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abcsystemconfig', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('numberOfUsersToGroup');
            $table->integer('numberOfDaysUntilNewVideoForQuotes');
            $table->integer('numberOfTopActToBeSuggested');
            $table->integer('defaultMaxDistanceForVenueRecommendation');
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
        Schema::dropIfExists('abcsystemconfig');
    }
}
