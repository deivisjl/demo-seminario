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
            $table->string('no')->nullable();
            $table->string('no_documento')->nullable();
            $table->date('fecha_documento')->nullable();
            $table->text('detalle');
            $table->text('solicitud');
            $table->string('nacionalidad');
            $table->string('telefono_contacto')->nullable();
            $table->string('correo_contacto')->nullable();
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('nit');
            $table->string('negocio');
            $table->text('direccion');
            $table->string('ip');
            $table->string('status')->default('Pendiente');
            $table->bigInteger('usuario_proceso_id')->unsigned()->nullable();
            $table->bigInteger('actividad_economica_id')->unsigned();
            $table->bigInteger('departamento_id')->unsigned();
            $table->bigInteger('municipio_id')->unsigned();
            $table->foreign('usuario_proceso_id')->references('id')->on('users');
            $table->foreign('municipio_id')->references('id')->on('municipio');
            $table->foreign('departamento_id')->references('id')->on('departamento');
            $table->foreign('actividad_economica_id')->references('id')->on('actividad_economica');
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
