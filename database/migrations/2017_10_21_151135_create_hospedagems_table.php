<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospedagemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospedagens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('observacao')->nullable();
            $table->boolean('estornado')->default(false);
            $table->datetime('data_compra');
            $table->decimal('custo_hospedagem', 10, 2)->nullable();
            $table->integer('viagens_id')->unsigned();
            $table->string('anexo_pdf')->nullable();
            $table->timestamps();
        });
        
        Schema::table('hospedagens', function (Blueprint $table) {
            DB::statement("ALTER TABLE hospedagens ADD anexo_hospedagem LONGBLOB NULL");
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
        Schema::dropIfExists('hospedagens');
    }
}
