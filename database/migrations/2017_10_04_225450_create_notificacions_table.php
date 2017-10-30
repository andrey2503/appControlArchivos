<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('idFinca')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('archivo_id')->unsigned();
            $table->date('fecha');
            $table->integer('tipo_archivo');
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('archivo_id')->references('id')->on('archivos_expedientes');
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
        Schema::dropIfExists('notificacions');
    }
}
