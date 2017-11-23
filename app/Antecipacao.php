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

    /** Consulta os comprovantes da Antecipacão
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
     public function antecipacao_comprovante()
    {
        return $this->hasMany('App\AntecipacaoComprovante','antecipacoes_id');
    }    

}
