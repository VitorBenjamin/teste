<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Clientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',100);
            $table->string('cnpj');
            $table->decimal('valor_km', 10, 2)->nullable()->default(null);
            $table->decimal('saldo', 10, 2)->nullable()->default(null);
            $table->integer('unidades_id')->unsigned();
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
        Schema::table('clientes', function (Blueprint $table) {
            //
        });
    }
}
