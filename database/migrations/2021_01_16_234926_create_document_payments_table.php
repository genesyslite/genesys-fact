<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->date('date_of_payment')->index();
            $table->char('payment_method_type_id', 2);
            $table->boolean('has_card')->default(false);
            $table->char('card_brand_id', 2)->nullable();
            $table->string('reference')->nullable();
            $table->decimal('change',12,2)->nullable();
            $table->decimal('payment', 12, 2);

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('card_brand_id')->references('id')->on('card_brands');
            $table->foreign('payment_method_type_id')->references('id')->on('payment_method_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_payments');
    }
}
