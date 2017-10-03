<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosExpedientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivos_expedientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('carpeta_id')->unsigned();
            $table->string('idFinca')->unsigned();
            $table->string('ruta_archivo');
            $table->integer('tipo_id');
            $table->foreign('tipo_id')->references('id')->on('tipo_documentos');
            $table->foreign('carpeta_id')->references('id')->on('sub_expedientes');
            $table->foreign('idFinca')->references('finca')->on('expedientes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archivos_expedientes');
    }
}
