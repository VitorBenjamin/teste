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
        	'tipo' => 'TRABALHISTA',
        	'descricao' => 'GUIA1'
        ]);

        TipoGuia::create([
        	'tipo' => 'TRABALHISTA',
        	'descricao' => 'GUIA2'
        ]);

        TipoGuia::create([
        	'tipo' => 'TRABALHISTA',
        	'descricao' => 'GUIA3'
        ]);

        TipoGuia::create([
        	'tipo' => 'TRABALHISTA',
        	'descricao' => 'GUIA4'
        ]);

        TipoGuia::create([
            'tipo' => 'CIVIL',
            'descricao' => 'GUIA5'
        ]);

        TipoGuia::create([
            'tipo' => 'CRIMINAL',
            'descricao' => 'GUIA6'
        ]);

        TipoGuia::create([
            'tipo' => 'CRIMINAL',
            'descricao' => 'GUIA7'
        ]);

        TipoGuia::create([
            'tipo' => 'AMBIENTAL',
            'descricao' => 'GUIA8'
        ]);
    }
}
