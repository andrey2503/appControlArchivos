<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClausuraNotificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clausura_notificacions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idFinca')->unsigned();
            $table->string('rutaArchivo');
            $table->date('fecha_inicio');
            $table->date('fecha_revicion');
            $table->integer('estado');
            $table->integer('lista');
            $table->integer('tipo_archivo');
            $table->timestamps();
            $table->foreign('idFinca')->references('finca')->on('expedientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clausura_notificacions');
    }
}
