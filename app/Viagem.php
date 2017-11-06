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
        'observacao', 'origem', 'destino', 'data_ida', 'data_volta', 'hospedagem', 'bagagem', 'kg', 'solicitacoes_id', 'reembolso_id'
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

    /** Consulta a Comprovantes por Viagem
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
    public function comprovantes(){

        return $this->hasMany('App\ViagemComprovante', 'viagens_id');
    }
}
