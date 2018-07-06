<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model
{
    protected $fillable = ['data','observacao','finalizado','users_id','clientes_id'];

    /** Consulta o usuário do Relárotio
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User','users_id');
    }

    /** Consulta o cliente do Relátorio
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function cliente()
    {
        return $this->belongsTo('App\Cliente','clientes_id');
    }
    
    public function solicitacao()
    {
        return $this->hasMany('App\Solicitacao', 'clientes_id');
    }
}
