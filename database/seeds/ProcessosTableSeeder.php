<?php

use Illuminate\Database\Seeder;

class ProcessosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Processo::create([
        	'codigo' => '11111111111111111111',
        	'clientes_id' => 1
        ]);

        Processo::create([
        	'codigo' => '22222222222222222222',
        	'clientes_id' => 1
        ]);

        Processo::create([
        	'codigo' => '33333333333333333333',
        	'clientes_id' => 2
        ]);

        Processo::create([
        	'codigo' => '44444444444444444444',
        	'clientes_id' => 3
        ]);
    }
}
