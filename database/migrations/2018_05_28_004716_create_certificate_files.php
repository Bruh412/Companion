<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificateFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CertificateFiles', function (Blueprint $table) {
            $table->string('fileID')->primary();
            $table->text('fileContent');
            $table->string('fileExt',10);
            $table->uuid('user_id');

            $table->foreign('user_id')->references('user_id')->on('systemusers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CertificateFiles');
    }
}
