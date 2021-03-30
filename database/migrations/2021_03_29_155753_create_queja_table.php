<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuejaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queja', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_documento')->nullable();
            $table->date('fecha_documento')->nullable();
            $table->text('detalle');
            $table->string('pais');
            $table->string('genero');
            $table->string('telefono_contacto')->nullable();
            $table->string('correo_contacto')->nullable();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresa');
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
        Schema::dropIfExists('queja');
    }
}
