<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYoutubeVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('YoutubeVideo', function (Blueprint $table) {
            // $table->increments('id');
            $table->string('videoID')->primary();
            $table->string('videoApi_id');
            $table->string('video_title');
            $table->longText('video_desc');
            $table->string('prevPageToken')->nullable();
            $table->string('nextPageToken')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('YoutubeVideo');
    }
}
