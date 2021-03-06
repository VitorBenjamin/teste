<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Comprovante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprovantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('anexo_pdf')->nullable();
            $table->integer('solicitacoes_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('comprovantes', function (Blueprint $table) {
            DB::statement("ALTER TABLE comprovantes ADD anexo LONGBLOB NULL");
            $table->foreign('solicitacoes_id')->references('id')->on('solicitacoes')
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
