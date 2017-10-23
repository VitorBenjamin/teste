<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cotacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotacoes', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->date('data');
            $table->string('descricao');
            $table->integer('quantidade');
            $table->integer('compras_id')->unsigned();
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
        Schema::table('cotacoes', function (Blueprint $table) {
            //
        });
    }
}
