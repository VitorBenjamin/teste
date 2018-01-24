<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TelefonesSolicitantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telefones_solicitantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('telefones_id')->unsigned();
            $table->integer('solicitantes_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('telefones_solicitantes', function (Blueprint $table) {
            $table->foreign('telefones_id')->references('id')->on('telefones')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('solicitantes_id')->references('id')->on('solicitantes')
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
