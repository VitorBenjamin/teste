<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'telefones'; 
	protected $fillable = [
		'numero'
	];

    /** Consulta a solicitacao por status
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function solicitantes()
    {
    	return $this->belongsToMany('App\Solicitante','telefones_solicitantes','telefones_id','solicitantes_id');
    }
    /** Consulta a solicitacao por status
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clientes()
    {
    	return $this->belongsToMany('App\Cliente','telefones_clientes','telefones_id','clientes_id');
    }
}