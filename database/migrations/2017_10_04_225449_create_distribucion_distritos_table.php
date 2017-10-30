<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistribucionDistritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribucion_distritos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_distrito')->unsigned();
            $table->integer('id_usuario')->unsigned();

            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_distrito')->references('id')->on('distritos');
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
        Schema::dropIfExists('distribucion_distritos');
    }
}
