<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->uuid('external_id');
            $table->unsignedBigInteger('establishment_id');
            $table->json('establishment');
            $table->char('soap_type_id', 2);
            $table->char('state_type_id', 2);
            $table->string('ubl_version');
            $table->string('document_type_id');
            $table->unsignedBigInteger('reference_sale_note_id');
            $table->unsignedBigInteger('reference_document_id')->nullable();
            $table->unsignedBigInteger('reference_quotation_id')->nullable();
            $table->unsignedBigInteger('reference_order_form_id')->nullable();
            $table->unsignedBigInteger('reference_order_note_id')->nullable();
            $table->char('series', 4);
            $table->integer('number');
            $table->date('date_of_issue');
            $table->time('time_of_issue');
            $table->unsignedBigInteger('customer_id');
            $table->json('customer');
            $table->text('observations');
            $table->string('transport_mode_type_id');
            $table->string('transfer_reason_type_id');
            $table->string('transfer_reason_description');
            $table->date('date_of_shipping');
            $table->boolean('transshipment_indicator');
            $table->string('port_code')->nullable();
            $table->string('unit_type_id');
            $table->decimal('total_weight', 10, 2);
            $table->integer('packages_number');
            $table->integer('container_number')->nullable();
            $table->json('origin');
            $table->json('delivery');
            $table->json('dispatcher')->nullable();
            $table->json('driver')->nullable();
            $table->string('license_plate')->nullable();
            $table->json('secondary_license_plates')->nullable();

            $table->string('transfer_reason_description')->nullable()->change();
            $table->text('observations')->nullable()->change();

            $table->json('legends')->nullable();
            $table->json('optional')->nullable();

            $table->string('filename')->nullable();
            $table->string('hash')->nullable();
            $table->json('soap_shipping_response')->nullable();
            $table->boolean('has_xml')->default(false);
            $table->boolean('has_pdf')->default(false);
            $table->boolean('has_cdr')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->foreign('soap_type_id')->references('id')->on('soap_types');
            $table->foreign('state_type_id')->references('id')->on('state_types');
            $table->foreign('document_type_id')->references('id')->on('cat_document_types');
            $table->foreign('customer_id')->references('id')->on('persons');
            $table->foreign('unit_type_id')->references('id')->on('cat_unit_types');
            $table->foreign('transport_mode_type_id')->references('id')->on('cat_transport_mode_types');
            $table->foreign('transfer_reason_type_id')->references('id')->on('cat_transfer_reason_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dispatches');
    }
}
