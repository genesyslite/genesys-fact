<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePaymentMethodTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_method_types', function (Blueprint $table) {
            $table->char('id', 2)->primary();
            $table->string('description');
            $table->boolean('has_card')->default(false);
            $table->integer('number_days')->nullable();
            $table->decimal('charge', 12, 2)->nullable();
        });

        DB::table('payment_method_types')->insert([
            ['id' => '01', 'description' => 'Efectivo', 'has_card' => false, 'number_days' => null, 'charge' => null],
            ['id' => '02', 'description' => 'Tarjeta de crédito', 'has_card' => true, 'number_days' => null, 'charge' => null],
            ['id' => '03', 'description' => 'Tarjeta de débito', 'has_card' => true, 'number_days' => null, 'charge' => null],
            ['id' => '04', 'description' => 'Transferencia', 'has_card' => false, 'number_days' => null, 'charge' => null],
            ['id' => '05', 'description' => 'Factura a 30 días', 'has_card' => false, 'number_days' => 30, 'charge' => null],
            ['id' => '06', 'description' => 'Tarjeta crédito visa', 'has_card' => true, 'number_days' => null, 'charge' => 3.68],
            ['id' => '07', 'description' => 'Contado contraentrega', 'has_card' => false, 'number_days' => null, 'charge' => null],
            ['id' => '08', 'description' => 'A 30 días', 'has_card' => false, 'number_days' => 30, 'charge' => null],
            ['id' => '09', 'description' => 'Crédito', 'has_card' => true, 'number_days' => null, 'charge' => null],
            ['id' => '10', 'description' => 'Contado', 'has_card' => false, 'number_days' => null, 'charge' => null],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods_types');
    }
}
