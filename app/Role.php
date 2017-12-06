<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    protected $fillable = ['name','display_name','description'];

    /** Consulta o usuário da solicitação
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsToMany('App\User','role_user','role_id','user_id');
    }
}
