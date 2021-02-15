<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertDataConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('configurations')->insert([
            [
                'field' => 'soap_send_id',
                'value' => '01',
                'type' => 'SUNAT'
            ],
            [
                'field' => 'soap_type_id',
                'value' => '01',
                'type' => 'SUNAT'
            ],
            [
                'field' => 'soap_username',
                'value' => '',
                'type' => 'SUNAT'
            ],
            [
                'field' => 'soap_password',
                'value' => null,
                'type' => 'SUNAT'
            ],
            [
                'field' => 'soap_url',
                'value' => null,
                'type' => 'SUNAT'
            ],
            [
                'field' => 'certificate',
                'value' => null,
                'type' => 'SUNAT'
            ],
            [
                'field' => 'certificate_due',
                'value' => '',
                'type' => 'SUNAT'
            ],
            [
                'field' => 'logo',
                'value' => '',
                'type' => 'SUNAT'
            ],
            [
                'field' => 'logo_store',
                'value' => '',
                'type' => 'SUNAT'
            ],
            [
                'field' => 'operation_amazonia',
                'value' => false,
                'type' => 'SUNAT'
            ],
            [
                'field' => 'send_auto',
                'value' => false,
                'type' => 'SUNAT'
            ],
            [
                'field' => 'formats',
                'value' => 'default',
                'type' => 'TEMPLATE'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configurations');
    }
}
