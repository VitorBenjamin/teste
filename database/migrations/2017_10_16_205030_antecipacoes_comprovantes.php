<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AntecipacoesComprovantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecipacoes_comprovantes', function (Blueprint $table) {
            //DB::statement("ALTER TABLE antecipacoes_comprovantes ADD anexo_comprovante LONGBLOB");
            $table->increments('id');
            $table->string('descricao');
            $table->datetime('data');
            $table->string('tipo_comprovante');
            $table->decimal('valor_aprovado', 10,2);
            $table->integer('antecipacoes_id')->unsigned();      
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
        Schema::table('antecipacoes_comprovantes', function (Blueprint $table) {
            //
        });
    }
}
