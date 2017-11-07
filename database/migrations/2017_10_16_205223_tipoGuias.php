<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TipoGuias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_guias', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->enum('tipo',['TRABALHISTA','CIVIL','CRIMINAL','AMBIENTAL']);
            $table->string('descricao',20);
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
        Schema::table('tipo_guias', function (Blueprint $table) {
            //
        });
    }
}
