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
        'nome', 'cnpj', 'logradouro', 'email', 'valor_km', 'saldo', 'unidades_id', 'cidades_id', 'estados_id'
    ];
    
    /** Consulta a Solicitacao da Despesa
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function unidade(){

    	return $this->belongsTo('App\Unidade','unidades_id');
    }
    public function cidade(){

        return $this->belongsTo('App\Cidade','cidades_id');
    }
    public function estado(){

        return $this->belongsTo('App\Estado','estados_id');
    }
    public function solicitacao()
    {
        return $this->hasMany('App\Solicitacao', 'clientes_id');
    }
    public function telefones()
    {
        return $this->belongsToMany('App\Telefone','telefones_clientes','clientes_id','telefones_id');
    }
}
