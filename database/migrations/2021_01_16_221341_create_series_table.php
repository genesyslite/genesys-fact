<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('establishment_id');
            $table->string('document_type_id');
            $table->string('number');
            $table->boolean('contingency')->default(false);
            $table->timestamps();

            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->foreign('document_type_id')->references('id')->on('cat_document_types');

        });

        DB::table('series')->insert([
            ['establishment_id' => 1, 'document_type_id' => '01', 'number' => 'F001'],
            ['establishment_id' => 1, 'document_type_id' => '03', 'number' => 'B001'],
            ['establishment_id' => 1, 'document_type_id' => '07', 'number' => 'FC01'],
            ['establishment_id' => 1, 'document_type_id' => '07', 'number' => 'BC01'],
            ['establishment_id' => 1, 'document_type_id' => '08', 'number' => 'FD01'],
            ['establishment_id' => 1, 'document_type_id' => '08', 'number' => 'BD01'],
            ['establishment_id' => 1, 'document_type_id' => '20', 'number' => 'R001'],
            ['establishment_id' => 1, 'document_type_id' => '09', 'number' => 'T001'],
            ['establishment_id' => 1, 'document_type_id' => '40', 'number' => 'P001'],
            ['establishment_id' => 1, 'document_type_id' => '80', 'number' => 'NV01'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series');
    }
}
