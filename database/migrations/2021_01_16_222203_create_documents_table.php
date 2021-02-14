<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->uuid('external_id')->index();
            $table->unsignedBigInteger('establishment_id');
            $table->json('establishment');
            $table->char('soap_type_id', 2);
            $table->char('state_type_id', 2);
            $table->string('ubl_version');
            $table->char('group_id', 2);
            $table->string('document_type_id');
            $table->char('series', 4)->index();
            $table->integer('number')->index();
            $table->date('date_of_issue')->index();
            $table->time('time_of_issue');
            $table->unsignedBigInteger('customer_id');
            $table->json('customer');
            $table->string('currency_type_id');
            $table->char('payment_method_type_id', 2)->nullable();

            $table->string('purchase_order')->nullable();
            $table->string('plate_number')->nullable();
            //$table->unsignedBigInteger('quotation_id')->nullable();
            //$table->unsignedBigInteger('sale_note_id')->nullable();
            //$table->unsignedBigInteger('order_note_id')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->decimal('exchange_rate_sale', 13, 3);
            $table->decimal('total_prepayment', 12, 2)->default(0);
            $table->decimal('total_charge', 12, 2)->default(0);
            $table->decimal('total_discount', 12, 2)->default(0);
            $table->decimal('total_exportation', 12, 2)->default(0);
            $table->decimal('total_free', 12, 2)->default(0);
            $table->decimal('total_taxed', 12, 2)->default(0);
            $table->decimal('total_unaffected', 12, 2)->default(0);
            $table->decimal('total_exonerated', 12, 2)->default(0);
            $table->decimal('total_igv', 12, 2)->default(0);
            $table->decimal('total_base_isc', 12, 2)->default(0);
            $table->decimal('total_isc', 12, 2)->default(0);
            $table->decimal('total_base_other_taxes', 12, 2)->default(0);
            $table->decimal('total_other_taxes', 12, 2)->default(0);
            $table->decimal('total_plastic_bag_taxes', 6, 2)->default(0);
            $table->decimal('total_taxes', 12, 2)->default(0);
            $table->decimal('total_value', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->boolean('has_prepayment')->default(false);
            $table->string('affectation_type_prepayment')->nullable();
            $table->boolean('was_deducted_prepayment')->default(false);
            $table->decimal('pending_amount_prepayment', 12, 2)->default(0);

            $table->json('charges')->nullable();
            $table->json('discounts')->nullable();
            $table->json('prepayments')->nullable();
            $table->json('guides')->nullable();
            $table->json('related')->nullable();
            $table->json('perception')->nullable();
            $table->json('detraction')->nullable();
            $table->json('legends')->nullable();
            $table->text('additional_information')->nullable();

            $table->string('filename')->nullable();
            $table->string('hash')->nullable();
            $table->longText('qr')->comment(' ')->nullable();
            $table->string('reference_data', 500)->nullable();
            $table->boolean('has_xml')->default(false);
            $table->boolean('has_pdf')->default(false);
            $table->boolean('has_cdr')->default(false);
            $table->boolean('send_server')->default(false);
            $table->boolean('success_shipping_status')->default(false);
            $table->json('shipping_status')->nullable();
            $table->boolean('success_sunat_shipping_status')->default(false);
            $table->json('sunat_shipping_status')->nullable();
            $table->json('query_status')->nullable();
            $table->boolean('success_query_status')->default(false);
            $table->boolean('total_canceled')->default(false);
            $table->json('soap_shipping_response')->nullable();
            $table->boolean('regularize_shipping')->default(false);
            $table->json('response_regularize_shipping')->nullable();
            $table->json('data_json')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->foreign('customer_id')->references('id')->on('persons');
            $table->foreign('soap_type_id')->references('id')->on('soap_types');
            $table->foreign('state_type_id')->references('id')->on('state_types');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('document_type_id')->references('id')->on('cat_document_types');
            $table->foreign('currency_type_id')->references('id')->on('cat_currency_types');
            //$table->foreign('sale_note_id')->references('id')->on('sale_notes');
            //$table->foreign('order_note_id')->references('id')->on('order_notes');
            //$table->foreign('quotation_id')->references('id')->on('quotations');
            $table->foreign('payment_method_type_id')->references('id')->on('payment_method_types');
            $table->foreign('seller_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
