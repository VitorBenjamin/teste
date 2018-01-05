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
        Schema::create('cotacoes', function (Blueprint $table) {
            //DB::statement("ALTER TABLE cotacoes ADD anexo_comprovante LONGBLOB");
            $table->increments('id');
            $table->date('data_cotacao');
            $table->string('descricao');
            $table->string('fornecedor');
            $table->integer('quantidade');
            $table->decimal('valor', 10,2);
            $table->date('data_compra');
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
        });
    }
}
