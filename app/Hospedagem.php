<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospedagem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'hospedagens';

    protected $fillable = [
        'data_cotacao','data_compra', 'observacao','estornado', 'custo_hospedagem', 'anexo_pdf','anexo_hospedagem', 'viagens_id'];
    
    /** Consulta a viagem por Comprovante
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */

    public function viagem(){

    	return $this->belongsTo('App\Viagem','viagens_id');
    }
}
