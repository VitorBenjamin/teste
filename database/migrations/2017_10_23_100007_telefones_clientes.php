<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TelefonesClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telefones_clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('telefones_id')->unsigned();
            $table->integer('clientes_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('telefones_clientes', function (Blueprint $table) {
            $table->foreign('telefones_id')->references('id')->on('telefones')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('clientes_id')->references('id')->on('clientes')
            ->onUpdate('cascade')->onDelete('cascade');
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
