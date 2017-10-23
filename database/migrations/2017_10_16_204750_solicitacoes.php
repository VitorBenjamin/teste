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
        Schema::table('solicitacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('codigo');
            $table->string('tipo');
            $table->string('origem_despesa');
            $table->integer('area_atuacoes_id')->unsigned();
            $table->integer('clientes_id')->unsigned();
            $table->integer('processos_id')->unsigned();
            $table->integer('users_id')->unsigned();
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
