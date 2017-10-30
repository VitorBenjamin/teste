<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translado extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'data_translado', 'observacao', 'origem','destino','ida_volta','distancia','solicitacoes_id'
    ];
    
    /** Consulta a solicitacao
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function solicitacao()
    {
        return $this->belongsTo('App\Solicitacao','solicitacoes_id');
    } 

}
