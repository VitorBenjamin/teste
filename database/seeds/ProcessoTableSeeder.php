<?php

use Illuminate\Database\Seeder;

class ProcessoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Processo::create([
            'codigo' => '1111111-11.1111.1.11.1111',
            'clientes_id' => 1
        ]);

        Processo::create([
            'codigo' => '2222222-22.2222.2.22.2222',
            'clientes_id' => 1
        ]);

        Processo::create([
            'codigo' => '3333333-33.3333.3.33.3333',
            'clientes_id' => 2
        ]);

        Processo::create([
            'codigo' => '4444444-44.4444.4.44.4444',
            'clientes_id' => 3
        ]);
    }
}
