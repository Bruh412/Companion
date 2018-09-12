<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NotificationsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Notifications', function (Blueprint $table) {
            $table->increments('id');

            // $table->string('triggeredBy')->nullable();
            $table->text('message');
            $table->string('recipient');

            $table->timestamps();

            // $table->foreign('triggeredBy')->references('user_id')->on('systemusers')->onDelete('cascade');
            $table->foreign('recipient')->references('user_id')->on('systemusers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Notifications');
    }
}
