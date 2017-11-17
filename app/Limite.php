<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Limite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['de','ate','area_atuacoes_id'];

	//Retornar os usuários da unidade
    public function users(){

    	return $this->belongsToMany('App\User','users_limites','limites_id','users_id');
    }
    	//Retornar os usuários da unidade
    public function unidades(){

    	return $this->belongsToMany('App\Unidade','limites_unidades','limites_id','unidades_id');
    }
    //Retornar os clientes da unidade
    public function areas(){

    	return $this->belongsTo('App\AreaAtuacao','area_atuacoes_id');
    }
}
