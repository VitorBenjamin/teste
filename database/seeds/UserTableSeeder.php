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
            'nome' => 'GERLEN BARBOSA',
            'email' => 'gerlenbarbosa@mosellolima.com.br',
            'password' => bcrypt('123456'),
            'codigo' => 1,
            'cpf' => 'COLOCAR CPF',
            'area_atuacoes_id' => 1,
            'telefone' => 'INSERIR O NUMERO',
            'unidades_id' => 1,
            'remember_token' => str_random(10),
        ]);

        User::create([
            'nome' => 'THIAGO SUAID',
            'email' => 'thiagosuaid@mosellolima.com.br',
            'password' => bcrypt('123456'),
            'codigo' => 2,
            'cpf' => 'COLOCAR CPF',
            'area_atuacoes_id' => 1,
            'telefone' => 'INSERIR O NUMERO',
            'unidades_id' => 1,
            'remember_token' => str_random(10),
        ]);
        User::create([
            'nome' => 'IGOR SAULO',
            'email' => 'igorsaulo@mosellolima.com.br',
            'password' => bcrypt('123456'),
            'codigo' => 3,
            'cpf' => 'COLOCAR CPF',
            'area_atuacoes_id' => 1,
            'telefone' => 'INSERIR O NUMERO',
            'unidades_id' => 1,
            'remember_token' => str_random(10),
        ]);
        User::create([
            'nome' => 'GABRIEL ALVES',
            'email' => 'gabrielelias@mosellolima.com.br',
            'password' => bcrypt('123456'),
            'codigo' => 4,
            'cpf' => 'COLOCAR CPF',
            'area_atuacoes_id' => 1,
            'telefone' => 'INSERIR O NUMERO',
            'unidades_id' => 1,
            'remember_token' => str_random(10),
        ]);
        User::create([
            'nome' => 'CARLA ASSUMPÇÃO',
            'email' => 'carlaassumpcao@mosellolima.com.br',
            'password' => bcrypt('123456'),
            'codigo' => 5,
            'cpf' => 'COLOCAR CPF',
            'area_atuacoes_id' => 1,
            'telefone' => 'INSERIR O NUMERO',
            'unidades_id' => 1,
            'remember_token' => str_random(10),
        ]);
        User::create([
            'nome' => 'MURILO GOMES',
            'email' => 'murilogomes@mosellolima.com.br',
            'password' => bcrypt('123456'),
            'codigo' => 6,
            'cpf' => 'COLOCAR CPF',
            'area_atuacoes_id' => 1,
            'telefone' => 'INSERIR O NUMERO',
            'unidades_id' => 1,
            'remember_token' => str_random(10),
        ]);
        User::create([
            'nome' => 'RITA SENNA',
            'email' => 'ritasen@mosellolima.com.br',
            'password' => bcrypt('123456'),
            'codigo' => 7,
            'cpf' => 'COLOCAR CPF',
            'area_atuacoes_id' => 1,
            'telefone' => 'INSERIR O NUMERO',
            'unidades_id' => 1,
            'remember_token' => str_random(10),
        ]);
        User::create([
            'nome' => 'FLÁVIO SANTOS',
            'email' => 'flaviosantos@mosellolima.com.br',
            'password' => bcrypt('123456'),
            'codigo' => 8,
            'cpf' => 'COLOCAR CPF',
            'area_atuacoes_id' => 1,
            'telefone' => 'INSERIR O NUMERO',
            'unidades_id' => 1,
            'remember_token' => str_random(10),
        ]);
        User::create([
            'nome' => 'TAIRO MOURA',
            'email' => 'tairomoura@mosellolima.com.br',
            'password' => bcrypt('123456'),
            'codigo' => 9,
            'cpf' => 'COLOCAR CPF',
            'area_atuacoes_id' => 1,
            'telefone' => 'INSERIR O NUMERO',
            'unidades_id' => 1,
            'remember_token' => str_random(10),
        ]);
        User::create([
            'nome' => 'MARCELO SENA',
            'email' => 'marcelosena@mosellolima.com.br',
            'password' => bcrypt('123456'),
            'codigo' => 10,
            'cpf' => 'COLOCAR CPF',
            'area_atuacoes_id' => 1,
            'telefone' => 'INSERIR O NUMERO',
            'unidades_id' => 1,
            'remember_token' => str_random(10),
        ]);
    }
}
