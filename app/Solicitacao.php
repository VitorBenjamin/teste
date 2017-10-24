<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'solicitacoes';
    protected $fillable = [
        'codigo', 'urgente', 'tipo','origem_despesa','area_atuacoes_id','clientes_id','processos_id','users_id'
    ];
    
    /** Consulta a area de atuação da solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function area_atuacao()
    {
        return $this->belongsTo('App\AreaAtuacao','area_atuacoes_id');
    }

/** Consulta o cliente da solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function cliente()
    {
        return $this->belongsTo('App\Cliente','clientes_id');
    }

/** Consulta o processo da solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function processo()
    {
        return $this->belongsTo('App\Processo','processos_id');
    }        

    /** Consulta o usuário da solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function user()
    {
        return $this->belongsTo('App\User','users_id');
    }    

}
