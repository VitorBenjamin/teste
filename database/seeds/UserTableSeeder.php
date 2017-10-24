<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::create([
    		'nome' => 'ADVOGADO',
    		'email' => 'advogado@gmail.com',
    		'password' => bcrypt('123456'),
    		'codigo' => 0001,
    		'cpf' => '21532598786',
    		'area_atuacoes_id' => 1,
            'telefone' => '32145698',
            'unidades_id' => 2,
            'remember_token' => str_random(10),
        ]);

    	User::create([
    		'nome' => 'ADVOGADO2',
    		'email' => 'advogado2@gmail.com',
    		'password' => bcrypt('123456'),
    		'codigo' => 0001,
    		'cpf' => '25463258712',
    		'area_atuacoes_id' => 2,
            'telefone' => '32145698',
            'unidades_id' => 1,
            'remember_token' => str_random(10),
        ]);

    	User::create([
    		'nome' => 'SUPERVISOR',
    		'email' => 'supervisor@gmail.com',
    		'password' => bcrypt('123456'),
    		'codigo' => 0001,
    		'cpf' => '05321485696',
    		'area_atuacoes_id' => 1,
            'telefone' => '32145698',
            'unidades_id' => 2,
            'remember_token' => str_random(10),
        ]);

    	User::create([
    		'nome' => 'FINACEIRO',
    		'email' => 'financeiro@gmail.com',
    		'password' => bcrypt('123456'),
    		'codigo' => 0001,
    		'cpf' => '02514523696',
    		'area_atuacoes_id' => 1,
            'telefone' => '32145698',
            'unidades_id' => 2,
            'remember_token' => str_random(10),
        ]);

    	User::create([
    		'nome' => 'ADM',
    		'email' => 'adm@gmail.com',
    		'password' => bcrypt('123456'),
    		'codigo' => 0001,
    		'cpf' => '74589615463',
    		'area_atuacoes_id' => 1,
            'telefone' => '32145698',
            'unidades_id' => 2,
            'remember_token' => str_random(10),
        ]);


    }
}
