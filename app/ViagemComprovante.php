<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViagemComprovante extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'viagens_comprovantes';

    protected $fillable = [
        'observacao', 'data_compra', 'custo_passagem', 'custo_hospedagem', 'custo_locacao', 'anexo_passagem', 'anexo_hospedagem', 'anexo_locacao', 'viagens_id'
    ];
    
    /** Consulta a viagem por Comprovante
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function viagem(){

    	return $this->belongsTo('App\Viagem','viagens_id');
    }
}
