<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['localidade'];
	
	//Retornar os usuários da unidade
    public function users(){

    	return $this->hasMany('App\User','unidades_id');
    }
    //Retornar os clientes da unidade
    public function clientes(){

    	return $this->hasMany('App\User','unidades_id');
    }
}
