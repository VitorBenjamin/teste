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
            $table->foreign('estados_id')->references('id')->on('estados');
            $table->foreign('cidades_id')->references('id')->on('cidades');
        });

    //Foreign Keys Tabela processo
        Schema::table('processos', function (Blueprint $table) {
            $table->foreign('clientes_id')->references('id')->on('clientes');        
        });

    //Foreign Keys Tabela solicitantes
        Schema::table('solicitantes', function (Blueprint $table) {
            $table->foreign('clientes_id')->references('id')->on('clientes');
        });
    //Foreign Keys Tabela solicitantes
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('area_atuacoes_id')->references('id')->on('area_atuacoes');
            $table->foreign('unidades_id')->references('id')->on('unidades');

        });

    //Foreign Keys Tabela solicitacoes
        Schema::table('solicitacoes', function (Blueprint $table) {
            $table->foreign('area_atuacoes_id')->references('id')->on('area_atuacoes');
            $table->foreign('unidades_id')->references('id')->on('unidades');
            $table->foreign('solicitantes_id')->references('id')->on('solicitantes');
            $table->foreign('clientes_id')->references('id')->on('clientes');
            $table->foreign('processos_id')->references('id')->on('processos');
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('aprovador_id')->references('id')->on('users');
            $table->foreign('relatorios_id')->references('id')->on('relatorios');
        }); 

    //Foreign Keys Tabela comentarios
        Schema::table('comentarios', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users');
        });       

    //Foreign Keys Tabela compras
        Schema::table('compras', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes')->onDelete('cascade');

        });  

    //Foreign Keys Tabela contacoes
        Schema::table('cotacoes', function (Blueprint $table) {
            $table->foreign('compras_id')->references('id')->on('compras');
            DB::statement("ALTER TABLE cotacoes ADD anexo_comprovante LONGBLOB NULL");
        });             

    //Foreign Keys Tabela viagens
        Schema::table('viagens', function (Blueprint $table) {
            DB::statement("ALTER TABLE viagens ADD anexo_passagem LONGBLOB NULL");
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes')->onDelete('cascade');
            $table->foreign('hospedagens_id')->references('id')->on('hospedagens')->onDelete('cascade');
            $table->foreign('locacoes_id')->references('id')->on('locacoes')->onDelete('cascade');

        });

        //Foreign Keys Tabela viagens_comprovantes
        // Schema::table('viagens_comprovantes', function (Blueprint $table) {
        //     DB::statement("ALTER TABLE viagens_comprovantes ADD anexo_passagem LONGBLOB NULL");
        //     DB::statement("ALTER TABLE viagens_comprovantes ADD anexo_hospedagem LONGBLOB NULL");
        //     DB::statement("ALTER TABLE viagens_comprovantes ADD anexo_locacao LONGBLOB NULL");
        // });

    //Foreign Keys Tabela antecipacoes
        Schema::table('antecipacoes', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes')->onDelete('cascade');
            DB::statement("ALTER TABLE antecipacoes ADD anexo_comprovante LONGBLOB NULL");

        });

    //Foreign Keys Tabela antecipacoes_comprovantes
        Schema::table('antecipacoes_comprovantes', function (Blueprint $table) {
            $table->foreign('antecipacoes_id')->references('id')->on('antecipacoes');
            DB::statement("ALTER TABLE antecipacoes_comprovantes ADD anexo_comprovante LONGBLOB NULL");
        });  

    //Foreign Keys Tabela despesas
        Schema::table('despesas', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes')->onDelete('cascade');
            DB::statement("ALTER TABLE despesas ADD anexo_comprovante LONGBLOB NULL");

        });

    //Foreign Keys Tabela translados
        Schema::table('translados', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes')->onDelete('cascade');

        });

    //Foreign Keys Tabela guias
        Schema::table('guias', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes')->onDelete('cascade');
            $table->foreign('tipo_guias_id')->references('id')->on('tipo_guias');
        });     

    //Foreign Keys Tabela solicitacoes_status
        Schema::table('solicitacoes_status', function (Blueprint $table) {
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');
            $table->primary(['solicitacoes_id', 'status_id']);
        });

    //Foreign Keys Tabela limites_unidades
        Schema::table('limites', function (Blueprint $table) {
            $table->foreign('area_atuacoes_id')->references('id')->on('area_atuacoes')->onDelete('cascade');
        });
    //Foreign Keys Tabela limites_unidades
        Schema::table('limites_unidades', function (Blueprint $table) {
            $table->foreign('limites_id')->references('id')->on('limites')->onDelete('cascade');
            $table->foreign('unidades_id')->references('id')->on('unidades')->onDelete('cascade');
            $table->primary(['limites_id', 'unidades_id']);
        });
    //Foreign Keys Tabela users_limites
        Schema::table('users_limites', function (Blueprint $table) {
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('limites_id')->references('id')->on('limites')->onDelete('cascade');
            $table->primary(['users_id', 'limites_id']);

        }); 
    //Foreign Keys Tabela users_limites
        Schema::table('users_clientes', function (Blueprint $table) {
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->primary(['users_id', 'clientes_id']);
        });
    //Foreign Keys Tabela users_limites
        Schema::table('coordenador_advogado', function (Blueprint $table) {
            $table->foreign('coordenador_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('advogado_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['coordenador_id', 'advogado_id']);
        });     
    //Foreign Keys Tabela users_limites
        Schema::table('relatorios', function (Blueprint $table) {
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('cascade');
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