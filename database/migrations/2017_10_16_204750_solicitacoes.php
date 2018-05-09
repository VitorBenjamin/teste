<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Solicitacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data_finalizado')->nullable();
            $table->integer('codigo');
            $table->boolean('urgente')->default(false);
            $table->string('tipo');
            $table->string('contrato');
            $table->string('origem_despesa');
            $table->integer('area_atuacoes_id')->unsigned();
            $table->integer('solicitantes_id')->unsigned()->nullable();
            $table->integer('clientes_id')->unsigned()->nullable();
            $table->integer('processos_id')->unsigned()->nullable();
            $table->integer('unidades_id')->unsigned();
            $table->integer('users_id')->unsigned();
            $table->integer('relatorios_id')->unsigned()->nullable();
            $table->integer('aprovador_id')->unsigned()->nullable();
            $table->enum('role',['ADVOGADO','ADMINISTRATIVO','COORDENADOR','FINANCEIRO']);
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
        Schema::table('solicitacoes', function (Blueprint $table) {
            //
        });
    }
}
