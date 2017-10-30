<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Translados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translados', function (Blueprint $table) {
           // 
            $table->increments('id');
            $table->date('data_translado');
            $table->string('observacao')->nullable();
            $table->string('origem');
            $table->string('destino');
            $table->boolean('ida_volta')->nullable();
            $table->integer('distancia')->nullable();
            $table->integer('solicitacoes_id')->unsigned();
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
        Schema::table('translados', function (Blueprint $table) {
            //
        });
    }
}
