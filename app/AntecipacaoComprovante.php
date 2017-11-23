<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntecipacaoComprovante extends Model
{
    protected $table = 'antecipacoes_comprovantes';
    protected $fillable = [
        'descricao', 'data', 'tipo_comprovante','valor', 'antecipacoes_id'
    ];

    
    /** Consulta os comprovantes da Antecipacão
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
     public function antecipacao()
    {
        return $this->belongsTo('App\Antecipacao','antecipacoes_id');
    }   
}
