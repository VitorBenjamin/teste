<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Despesas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despesas', function (Blueprint $table) {
            //DB::statement("ALTER TABLE despesas ADD anexo_comprovante LONGBLOB");
            $table->increments('id');
            $table->string('descricao');
            $table->datetime('data');
            $table->string('tipo_comprovante');
            $table->decimal('valor', 10,2);
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
        Schema::table('despesas', function (Blueprint $table) {
            //
        });
    }
}
