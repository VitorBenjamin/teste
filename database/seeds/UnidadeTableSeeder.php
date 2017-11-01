<?php

use Illuminate\Database\Seeder;

class UnidadeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unidade::create([
            'localidade' => 'EUNÁPOLIS',
            
        ]);

        Unidade::create([
            'localidade' => 'PORTO SEGURO',
            
        ]);

        Unidade::create([
            'localidade' => 'TEXEIRA DE FREITAS',
            
        ]);

        Unidade::create([
            'localidade' => 'SALVADOR',
            
        ]);

        Unidade::create([
            'localidade' => 'NANUQUE',
            
        ]);

        Unidade::create([
            'localidade' => 'GUARAPARI',
            
        ]);        

    }
}
