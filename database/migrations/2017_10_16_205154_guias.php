<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Guias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guias', function (Blueprint $table) {
            //DB::statement("ALTER TABLE guias ADD anexo_pdf LONGBLOB");
            $table->increments('id');
            $table->date('data_limite');
            $table->boolean('prioridade')->default(false);
            $table->string('observacao')->nullable();
            $table->string('reclamante');
            $table->string('reclamante');
            $table->string('perfil_pagamento');
            $table->string('banco');
            $table->integer('solicitacoes_id')->unsigned();
            $table->integer('tipo_guias_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guias', function (Blueprint $table) {
            //
        });
    }
}
