<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'cidades'; 
	protected $fillable = [
		'nome'
	];

    /** Consulta a solicitacao por status
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clientes()
    {
    	return $this->belongsToMany('App\Cliente','cidades_clientes','cidades_id','clientes_id');
    }
}
