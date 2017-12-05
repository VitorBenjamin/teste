<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antecipacao extends Model

{
    protected $table = 'antecipacoes';
    protected $fillable = [
        'descricao', 'data_recebimento', 'valor','anexo_comprovante', 'solicitacoes_id'
    ];
    
    /** Consulta a Solicitacao da Antecipacão
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function solicitacao()
    {
        return $this->belongsTo('App\Solicitacao','solicitacoes_id');
    }

    /** Consulta as Despesas da  solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function despesa()
    {
        return $this->hasMany('App\Despesa','solicitacoes_id');
    }    

}
