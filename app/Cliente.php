<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'clientes';
    protected $fillable = [
        'nome', 'cnpj', 'valor_km', 'saldo', 'unidades_id'
    ];
    
    /** Consulta a Solicitacao da Despesa
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function unidade(){

    	return $this->belongsTo('App\Unidade','unidades_id');
    }

    public function solicitacao()
    {
        return $this->hasMany('App\Solicitacao', 'clientes_id');
    }
}
