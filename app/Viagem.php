<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viagem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'viagens';

    protected $fillable = [
        'observacao', 'estornado', 'origem', 'destino', 'data_ida', 'data_volta', 'hospedagem', 'bagagem', 'kg', 'locacao', 'solicitacoes_id','valor', 'observacao_comprovante', 'data_compra', 'anexo_passagem'
    ];

    /** Consulta a Solicitacao por Viagem
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
    public function reembolso(){

        return $this->belongsTo('App\Solicitacao', 'reembolso_id');
    }

    /** Consulta a Solicitacao por Viagem
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function solicitacao(){

    	return $this->belongsTo('App\Solicitacao', 'solicitacoes_id');
    }

    /** Consulta as Despesas da  solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function despesa()
    {
        return $this->hasMany('App\Despesa','solicitacoes_id');
    }

    /** Consulta a Comprovantes por Viagem
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
    public function hospedagem(){

        return $this->hasOne('App\Hospedagem', 'viagens_id');
    }
    /** Consulta a Comprovantes por Viagem
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
    public function locacao(){

        return $this->hasOne('App\Hospedagem', 'viagens_id');
    }
}
