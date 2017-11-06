<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'cpf','telefone','clientes_id'
    ];
    
    /** Consulta a Empresa-Cliente do solicitante
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function cliente()
    {
        return $this->belongsTo('App\Cliente','clientes_id');
    }  

}