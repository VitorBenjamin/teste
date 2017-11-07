<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'status'; 
    protected $fillable = [
        'descricao'
    ];
    
    /** Consulta a solicitacao por status
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function solicitacao()
    {
        return $this->belongsToMany('App\Solicitacao','solicitacoes_status','solicitacoes_id','status_id');
    }
    
}
