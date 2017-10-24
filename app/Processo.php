<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'codigo','clientes_id'
    ];
    
	/** Consulta o cliente da Processo
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function cliente()
	{
		return $this->belongsTo('App\Cliente','clientes_id');
	}  
}
