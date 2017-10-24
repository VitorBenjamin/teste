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
            'localidade' => 'Eunápolis',
            
        ]);

        Unidade::create([
            'localidade' => 'Porto Seguro',
            
        ]);

        Unidade::create([
            'localidade' => 'Texeira de Freitas',
            
        ]);

        Unidade::create([
            'localidade' => 'Salvador',
            
        ]);

        Unidade::create([
            'localidade' => 'Nanuque',
            
        ]);

        Unidade::create([
            'localidade' => 'Guarapari',
            
        ]);        

    }
}
