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
        Schema::table('viagens', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->boolean('urgente')->default(false);
            $table->string('origem');
            $table->string('destino');
            $table->datetime('ida');
            $table->datetime('volta');
            $table->boolean('hospedagem')->nullable();
            $table->boolean('bagagem')->nullable();
            $table->boolean('locacao')->nullable();
            $table->integer('kg')->nullable();
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
        Schema::table('viagens', function (Blueprint $table) {
            //
        });
    }
}
