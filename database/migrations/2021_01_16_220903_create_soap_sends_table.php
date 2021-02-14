<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSoapSendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soap_sends', function (Blueprint $table) {
            $table->char('id', 2)->primary();
            $table->string('description');
        });
        DB::table('soap_sends')->insert([
            ['id' => '01', 'description' => 'Sunat'],
            ['id' => '02', 'description' => 'Ose'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soap_sends');
    }
}
