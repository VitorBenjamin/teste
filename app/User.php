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
        'nome', 'email', 'password', 'codigo','cpf', 'telefone', 'area_atuacoes_id', 'unidades_id', 'dados_id' , 'ativo'
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

    /** Consulta a dados do usuário
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function dados()
    {
        return $this->belongsTo('App\Dados','dados_id');
    } 
    
    /** Consulta a unidade do usuário
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function limites()
    {
        return $this->belongsToMany('App\Limite','users_limites','users_id','limites_id');
    }

    /** Consulta os clientes do usuário
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function clientes()
    {
        return $this->belongsToMany('App\Cliente','users_clientes','users_id','clientes_id');
    }

    /** Consulta os advogado do usuário
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function users()
    {
        return $this->belongsToMany('App\User','coordenador_advogado','coordenador_id','advogado_id');
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
