<?php

use Illuminate\Database\Seeder;

class ClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Cliente::create([
    		'nome' => 'VERACEL',
    		'cnpj' => '652143',
    		'valor_km' => 5,
    		'saldo' => 2000,
    		'unidades_id' => 1,
    	]);

    	Cliente::create([
    		'nome' => 'BRASMOTO',
    		'cnpj' => '142365',
    		'valor_km' => 3,
    		'saldo' => 5000,
    		'unidades_id' => 2,
    	]);

    	Cliente::create([
    		'nome' => 'FIAT',
    		'cnpj' => '613254',
    		'valor_km' => 2,
    		'saldo' => 3562,
    		'unidades_id' => 1,
    	]);

    	Cliente::create([
    		'nome' => 'AGENCIA VILACA',
    		'cnpj' => '451623',
    		'valor_km' => 1,
    		'saldo' => 50000,
    		'unidades_id' => 2,
    	]);

        Cliente::create([
            'nome' => 'PORTOVEL',
            'cnpj' => '451206',
            'valor_km' => 1,
            'saldo' => 50000,
            'unidades_id' => 3,
        ]);

        Cliente::create([
            'nome' => '2TREE',
            'cnpj' => '984513',
            'valor_km' => 1,
            'saldo' => 50000,
            'unidades_id' => 3,
        ]);

        Cliente::create([
            'nome' => 'EXPRESSO NEPOMUCENO',
            'cnpj' => '321546',
            'valor_km' => 1,
            'saldo' => 50000,
            'unidades_id' => 2,
        ]);

        Cliente::create([
            'nome' => 'MOSELLO LIMA',
            'cnpj' => '854236',
            'valor_km' => 1,
            'saldo' => 50000,
            'unidades_id' => 1,
        ]);
    }
}
