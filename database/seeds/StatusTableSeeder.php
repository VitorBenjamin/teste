<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Status::create([
    		'descricao' => 'ABERTO',

    	]);
        Status::create([
            'descricao' => 'ANDAMENTO',
            
        ]);
        Status::create([
            'descricao' => 'APROVADO',
            
        ]);
        Status::create([
            'descricao' => 'REPROVADO',
            
        ]);
        Status::create([
            'descricao' => 'DEVOLVIDO',
            
        ]);
        Status::create([
            'descricao' => 'RECORRENTE',
            
        ]);
        Status::create([
            'descricao' => 'FINALIZADO',
            
        ]);
        Status::create([
            'descricao' => 'ABERTO-FINANCEIRO',

        ]);
        Status::create([
            'descricao' => 'ANDAMENTO-RECORRENTE',
            
        ]);
        Status::create([
            'descricao' => 'DEVOLVIDO-FINANCEIRO',

        ]);
        Status::create([
            'descricao' => 'APROVADO-RECORRENTE',
            
        ]);
        Status::create([
            'descricao' => 'ANDAMENTO-FINANCEIRO',
            
        ]);
        Status::create([
            'descricao' => 'APROVADO-FINANCEIRO',
            
        ]);
        Status::create([
            'descricao' => 'RECORRENTE-FINANCEIRO',
            
        ]);
        Status::create([
            'descricao' => 'ABERTO-ETAPA2',

        ]);
        Status::create([
            'descricao' => 'APROVADO-ETAPA2',
            
        ]);
        Status::create([
            'descricao' => 'DEVOLVIDO-ETAPA2',
            
        ]);
        Status::create([
            'descricao' => 'ANDAMENTO-ETAPA2',
            
        ]);
        Status::create([
            'descricao' => 'COORDENADOR-ABERTO',
            
        ]);
        Status::create([
            'descricao' => 'COORDENADOR-APROVADO',
            
        ]);
         Status::create([
            'descricao' => 'COORDENADOR-ANDAMENTO',
            
        ]);
        Status::create([
            'descricao' => 'COORDENADOR-ANDAMENTO2',
            
        ]);
        Status::create([
            'descricao' => 'COORDENADOR-ABERTO2',
            
        ]);
        Status::create([
            'descricao' => 'COORDENADOR-APROVADO2',
            
        ]);
        Status::create([
            'descricao' => 'ANDAMENTO-ADMINISTRATIVO',
            
        ]);
        
    }
}
