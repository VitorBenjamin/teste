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
    		'descricao' => 'FECHADO',
    		
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
    		'descricao' => 'DEVOLVIDO-FINANCEIRO',
    		
    	]);
    	Status::create([
    		'descricao' => 'FINALIZADO',
    		
    	]);
    }
}
