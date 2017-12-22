<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model
{
    protected $fillable = ['data','users_id','clientes_id'];

    /** Consulta o usuário do Relárotio
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    /** Consulta o cliente do Relátorio
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function clientes()
    {
        return $this->belongsTo('App\Cliente','clientes_id');
    }
}
