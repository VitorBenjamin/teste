<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprovante extends Model
{
    protected $fillable = [
        'anexo_pdf','anexo_comprovante', 'solicitacoes_id'
    ];
    
    /** Consulta a Solicitacao da Compra
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function solicitacao()
    {
        return $this->belongsTo('App\Solicitacao','solicitacoes_id');
    }
}
