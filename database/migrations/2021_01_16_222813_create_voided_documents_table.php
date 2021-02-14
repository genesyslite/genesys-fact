<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoidedDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voided_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('voided_id');
            $table->unsignedBigInteger('document_id');
            $table->string('description');

            $table->foreign('voided_id')->references('id')->on('voided')->onDelete('cascade');
            $table->foreign('document_id')->references('id')->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voided_documents');
    }
}
