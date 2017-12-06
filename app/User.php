<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'password','codigo','cpf','telefone','area_atuacoes_id','unidades_id'
    ];
    
    /** Consulta a area de atuação do usuário
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function area_atuacao()
    {
        return $this->belongsTo('App\AreaAtuacao','area_atuacoes_id');
    }

    /** Consulta a unidade do usuário
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function unidades()
    {
        return $this->belongsTo('App\Unidade','unidades_id');
    } 
    
    /** Consulta a unidade do usuário
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function limites()
    {
        return $this->belongsToMany('App\Limite','users_limites','users_id','limites_id');
    }
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
