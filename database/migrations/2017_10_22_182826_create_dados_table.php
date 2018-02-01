<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rg')->nullable();;
            $table->string('data_nascimento')->nullable();
            $table->string('endereco')->nullable();;
            $table->string('cidade')->nullable();;
            $table->string('estado')->nullable();;
            $table->string('cep')->nullable();;
            $table->string('telefone')->nullable();;
            $table->string('estado_civil')->nullable();;
            $table->string('funcao')->nullable();;
            $table->string('dados_bancarios')->nullable();;
            $table->string('viagem')->nullable();;
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
        Schema::dropIfExists('dados');
    }
}
