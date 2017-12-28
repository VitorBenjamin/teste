<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('observacao')->nullable();
            $table->boolean('estornado')->default(false);
            $table->datetime('data_compra');
            $table->decimal('valor', 10, 2)->nullable();
            $table->integer('viagens_id')->unsigned();
            $table->timestamps();
            
        });
        
        Schema::table('locacoes', function (Blueprint $table) {
            DB::statement("ALTER TABLE locacoes ADD anexo_locacao LONGBLOB");
            $table->foreign('viagens_id')->references('id')->on('viagens')
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
        Schema::dropIfExists('locacoes');
    }
}
