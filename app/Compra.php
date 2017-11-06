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
        'data_compra','descricao', 'quantidade', 'solicitacoes_id'
    ];
    
    /** Consulta a Solicitacao da compra
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function solicitacao()
    {
        return $this->belongsTo('App\Solicitacao','solicitacoes_id');
    }
}