<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'comentarios';
    protected $fillable = [
        'status', 'publico', 'comentario', 'users_id', 'solicitacoes_id'
    ];

    /** Consulta a Solicitacao dos comentario
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function solicitacao()
    {
        return $this->belongsTo('App\Solicitacao','solicitacoes_id');
    }

    /** Consulta o usuário da comentário
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User','users_id');
    }   
}
