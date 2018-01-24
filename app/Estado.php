<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'estados'; 
	protected $fillable = [
		'nome'
	];

    /** Consulta a solicitacao por status
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cliente()
    {
    	return $this->belongsTo('App\Cliente','cidades_id');
    }
}
