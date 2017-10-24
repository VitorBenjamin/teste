<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaAtuacao extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'area_atuacoes';
    protected $fillable = [
        'tipo'
    ];
    
    /** Consulta o Usuario daquela area de atuação
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function user(){

    	return $this->hasMany('App\User','area_atuacoes_id');
    }
}
