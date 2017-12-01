<?php

use Illuminate\Database\Seeder;

class AreaAtuacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AreaAtuacao::create([
        	'tipo' => 'CRIMINAL'
        ]);

        AreaAtuacao::create([
        	'tipo' => 'TRABALHISTA'
        ]);

        AreaAtuacao::create([
        	'tipo' => 'CÍVIL'
        ]);

        AreaAtuacao::create([
        	'tipo' => 'AMBIENTAL'
        ]);
    }
}
