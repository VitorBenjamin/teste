<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViagemComprovante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('viagem_comprovantes', function (Blueprint $table) {
            //DB::statement("ALTER TABLE chamados ADD img LONGBLOB");
            $table->increments('id');
            $table->boolean('urgente')->default(false);
            $table->datetime('data_compra');
            $table->decimal('custo_passagem', 10, 2);
            $table->decimal('custo_hospedagem', 10, 2);
            $table->decimal('custo_locacao', 10, 2);
            $table->binary('anexo_passagem');
            $table->binary('anexo_hospedagem');
            $table->binary('anexo_locacao');
            $table->integer('viagens_id')->unsigned();            
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
        Schema::table('viagem_comprovantes', function (Blueprint $table) {
            //
        });
    }
}
