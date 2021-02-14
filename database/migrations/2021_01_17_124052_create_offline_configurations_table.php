<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOfflineConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_configurations', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_client')->default(false);
            $table->string('token_server')->nullable();
            $table->string('url_server')->nullable();
            $table->timestamps();
        });

        DB::table('offline_configurations')->insert([
            ['id' => '1', 'is_client' => false, 'token_server' => null, 'url_server' => null],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offline_configurations');
    }
}
