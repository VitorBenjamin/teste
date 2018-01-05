<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'data_compra','descricao', 'quantidade', 'solicitacoes_id','anexo_pdf'
    ];
    
    /** Consulta a Solicitacao da Compra
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function solicitacao()
    {
        return $this->belongsTo('App\Solicitacao','solicitacoes_id');
    }

    /** Consulta a Solicitacao da Compra
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function cotacao()
    {
        return $this->hasMany('App\Cotacao','compras_id');
    }
}
