<?php

use Illuminate\Database\Seeder;

class SolicitanteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Solicitante::create([

        	'nome' => 'JOAO HENRIQUE',
        	'cpf' => '02332641285',
        	'telefone' => '73955487513',
        	'clientes_id' => 1,
        ]);

        Solicitante::create([

        	'nome' => 'JESSICA SANTOS',
        	'cpf' => '05123647852',
        	'telefone' => '73912548632',
        	'clientes_id' => 1,
        ]);

        Solicitante::create([

        	'nome' => 'FABIANA SOUZA',
        	'cpf' => '12352074689',
        	'telefone' => '73932145212',
        	'clientes_id' => 2,
        ]);

        Solicitante::create([

        	'nome' => 'FABIO SANTOS',
        	'cpf' => '05123244752',
        	'telefone' => '73979548632',
        	'clientes_id' => 3,
        ]);
    }
}
