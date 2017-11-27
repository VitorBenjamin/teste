<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Viagens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viagens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('observacao')->nullable();
            $table->string('origem');
            $table->string('destino');
            $table->datetime('data_ida');
            $table->datetime('data_volta')->nullable();
            $table->boolean('hospedagem')->nullable();
            $table->boolean('bagagem')->nullable();
            $table->boolean('locacao')->nullable();
            $table->integer('kg')->nullable();
            $table->integer('solicitacoes_id')->unsigned();
            $table->integer('viagens_comprovantes_id')->unsigned()->nullable();
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
        Schema::table('viagens', function (Blueprint $table) {
            //
        });
    }
}
