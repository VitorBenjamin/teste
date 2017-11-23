<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Antecipacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecipacoes', function (Blueprint $table) {
            //DB::statement("ALTER TABLE antecipacoes ADD anexo_comprovante LONGBLOB");
            $table->increments('id');
            $table->string('descricao');
            $table->datetime('data_recebimento');
            $table->decimal('valor', 10, 2);
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
        Schema::table('antecipacoes', function (Blueprint $table) {
            //
        });
    }
}
