<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'cotacoes';

     protected $fillable = [
        'descricao', 'data_cotacao', 'fornecedor', 'quantidade', 'anexo_comprovante', 'compras_id'
    ];
    
    /** Consulta a Solicitacao da Despesa
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function compra()
    {
        return $this->belongsTo('App\Compra','compras_id');
    }
}