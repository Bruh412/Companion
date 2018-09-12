<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    // /**
    //  * Run the migrations.
    //  *
    //  * @return void
    //  */
    // public function up()
    // {
    //     Schema::create('notifications', function (Blueprint $table) {
    //         $table->string('notif_id')->primary();
    //         $table->string('message');
    //         $table->string('recipient');
    //         $table->foreign('recipient')->references('user_id')->on('systemusers')->onDelete('cascade');
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::dropIfExists('notifications');
    // }
}
