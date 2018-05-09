<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'locacoes';

    protected $fillable = [
        'data_cotacao','data_compra','observacao','estornado', 'valor', 'anexo_locacao', 'viagens_id'];
    
    /** Consulta a viagem por Comprovante
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function viagem(){

    	return $this->belongsTo('App\Viagem','viagens_id');
    }
}
