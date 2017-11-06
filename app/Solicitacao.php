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
    'codigo', 'urgente', 'tipo', 'origem_despesa', 'contrato', 'area_atuacoes_id', 'clientes_id', 'solicitantes_id', 'processos_id', 'unidades_id', 'users_id'
    ];
    
    /** Consulta os status de  solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsToMany('App\Status','solicitacoes_status','solicitacoes_id','status_id');
    }
    /** Consulta as Despesas da  solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function despesa()
    {
        return $this->hasMany('App\Despesa','solicitacoes_id');
    }
    
    /** Consulta as Despesas da  solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viagem()
    {
        return $this->hasMany('App\Viagem','solicitacoes_id');
    }

    /** Consulta os Translados da  solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translado()
    {
        return $this->hasMany('App\Translado','solicitacoes_id');
    }

    /** Consulta as compras da solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function compra()
    {
        return $this->hasMany('App\Compra','solicitacoes_id');
    }
    
    /** Consulta a area de atuação da solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area_atuacao()
    {
        return $this->belongsTo('App\AreaAtuacao','area_atuacoes_id');
    }

    /** Consulta o solicitante da solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function solicitante()
    {
        return $this->belongsTo('App\Solicitante','solicitantes_id');
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
