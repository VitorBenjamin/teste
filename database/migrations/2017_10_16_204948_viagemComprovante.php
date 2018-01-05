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
    // public function up()
    // {
    //     Schema::create('viagens_comprovantes', function (Blueprint $table) {
    //         //DB::statement("ALTER TABLE viagem_comprovantes ADD anexo_passagem LONGBLOB");
    //         //DB::statement("ALTER TABLE viagem_comprovantes ADD anexo_hospedagem LONGBLOB");
    //         //DB::statement("ALTER TABLE viagem_comprovantes ADD anexo_locacao LONGBLOB");
    //         $table->increments('id');
    //         $table->string('observacao')->nullable();
    //         $table->datetime('data_compra');
    //         $table->decimal('anexo_pdf_passagem', 10, 2);
    //         $table->decimal('anexo_pdf_hospedagem', 10, 2)->nullable();
    //         $table->decimal('anexo_pdf_locacao', 10, 2)->nullable();
    //         $table->decimal('custo_passagem', 10, 2);
    //         $table->decimal('custo_hospedagem', 10, 2)->nullable();
    //         $table->decimal('custo_locacao', 10, 2)->nullable();
    //         $table->timestamps();
    //         $table->softDeletes();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::table('viagem_comprovantes', function (Blueprint $table) {
    //         //
    //     });
    // }
}
