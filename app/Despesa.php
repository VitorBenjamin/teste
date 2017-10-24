<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descricao', 'data', 'tipo_comprovante', 'valor', 'anexo_comprovante', 'solicitacoes_id'
    ];
    
    /** Consulta a Solicitacao da Despesa
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function solicitacao()
    {
        return $this->belongsTo('App\Solicitacao','solicitacoes_id');
    }
}
