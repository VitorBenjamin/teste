<?php

use Illuminate\Database\Seeder;

class TipoGuiaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoGuia::create([
        	'tipo' => 'trabalhista',
        	'descricao' => 'GUIA1'
        ]);

        TipoGuia::create([
        	'tipo' => 'trabalhista',
        	'descricao' => 'GUIA2'
        ]);

        TipoGuia::create([
        	'tipo' => 'trabalhista',
        	'descricao' => 'GUIA3'
        ]);

        TipoGuia::create([
        	'tipo' => 'trabalhista',
        	'descricao' => 'GUIA4'
        ]);
    }
}
