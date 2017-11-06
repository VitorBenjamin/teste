<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    //Foreign Keys Tabela clientes
        Schema::table('clientes', function (Blueprint $table) {
            $table->foreign('unidades_id')->references('id')->on('unidades');
        });

    //Foreign Keys Tabela processo
        Schema::table('processos', function (Blueprint $table) {
            $table->foreign('clientes_id')->references('id')->on('clientes');        
        });

    //Foreign Keys Tabela solicitantes
        Schema::table('solicitantes', function (Blueprint $table) {
            $table->foreign('clientes_id')->references('id')->on('clientes');
        });

    //Foreign Keys Tabela solicitacoes
        Schema::table('solicitacoes', function (Blueprint $table) {
            $table->foreign('area_atuacoes_id')->references('id')->on('area_atuacoes');
            $table->foreign('clientes_id')->references('id')->on('clientes');
            $table->foreign('processos_id')->references('id')->on('processos');
            $table->foreign('users_id')->references('id')->on('users');
        }); 

    //Foreign Keys Tabela comentarios
        Schema::table('comentarios', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes');
            $table->foreign('users_id')->references('id')->on('users');
        });       

    //Foreign Keys Tabela compras
        Schema::table('compras', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes');
        });  

    //Foreign Keys Tabela contacoes
        Schema::table('cotacoes', function (Blueprint $table) {
            $table->foreign('compras_id')->references('id')->on('compras');
            DB::statement("ALTER TABLE cotacoes ADD anexo_comprovante LONGBLOB");

        });             

    //Foreign Keys Tabela viagens
        Schema::table('viagens', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes');

        });

    //Foreign Keys Tabela viagens_comprovantes
        Schema::table('viagens_comprovantes', function (Blueprint $table) {
            $table->foreign('viagens_id')->references('id')->on('viagens');
            DB::statement("ALTER TABLE viagens_comprovantes ADD anexo_passagem LONGBLOB");
            DB::statement("ALTER TABLE viagens_comprovantes ADD anexo_hospedagem LONGBLOB");
            DB::statement("ALTER TABLE viagens_comprovantes ADD anexo_locacao LONGBLOB");
        });

    //Foreign Keys Tabela antecipacoes
        Schema::table('antecipacoes', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes');
        });

    //Foreign Keys Tabela antecipacoes_comprovantes
        Schema::table('antecipacoes_comprovantes', function (Blueprint $table) {
            $table->foreign('antecipacoes_id')->references('id')->on('antecipacoes');
            DB::statement("ALTER TABLE antecipacoes_comprovantes ADD anexo_comprovante LONGBLOB");
        });  

    //Foreign Keys Tabela despesas
        Schema::table('despesas', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes');
            DB::statement("ALTER TABLE despesas ADD anexo_comprovante LONGBLOB");
        });

    //Foreign Keys Tabela translados
        Schema::table('translados', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes');
        });

    //Foreign Keys Tabela guias
        Schema::table('guias', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes');
            $table->foreign('tipo_guias_id')->references('id')->on('tipo_guias');
        });     

    //Foreign Keys Tabela solicitacoes_status
        Schema::table('solicitacoes_status', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes');
            $table->foreign('status_id')->references('id')->on('status');
        });
    
    //Foreign Keys Tabela limites_unidades
        Schema::table('limites_unidades', function (Blueprint $table) {
            $table->foreign('limites_id')->references('id')->on('limites');
            $table->foreign('unidades_id')->references('id')->on('unidades');
        });        
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
