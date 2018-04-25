<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'data_limite',  'estornado', 'prioridade', 'observacao','reclamante','perfil_pagamento','banco','anexo_guia','valor','solicitacoes_id','tipo_guias_id'
    ];
    
    /** Consulta a Solicitação da Guia
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitacao()
    {
    	return $this->belongsTo('App\Solicitacao','solicitacoes_id');
    }

	/** Consulta o Tipo_Guia da Guia
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function tipoGuia()
	{
		return $this->belongsTo('App\TipoGuia','tipo_guias_id');
	}
}
