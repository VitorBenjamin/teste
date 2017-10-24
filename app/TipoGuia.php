<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoGuia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo', 'descricao'
    ];
    
    /** Consulta as guias
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function guias()
    {
        return $this->hasMany('App\Guia','tipo_guias_id');
    } 
}
