<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dados extends Model
{
    protected $table = 'dados';

    protected $fillable = [
        'rg','data_nascimento','endereco','cidade','estado','cep','telefone','estado_civil','funcao','dados_bancarios','viagem'
    ];

}
