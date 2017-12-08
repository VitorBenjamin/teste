<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('roles')->insert([
    		'name' => config('constantes.user_god'),
    		'display_name' => 'GOD',
    		'description' => 'USUÁRIO COM PRIVILÉGIOS DE GOD',
    	]);

    	DB::table('roles')->insert([
    		'name' => config('constantes.user_advogado'),
    		'display_name' => 'ADVOGADO',
    		'description' => 'USUÁRIO COM PRIVILÉGIOS DE ADVOGADO',
    	]);
    	DB::table('roles')->insert([
    		'name' => config('constantes.user_coordenador'),
    		'display_name' => 'COORDENADOR',
    		'description' => 'USUÁRIO COM PRIVILÉGIOS DE COORDENADOR',
    	]);
    	DB::table('roles')->insert([
    		'name' => config('constantes.user_financeiro'),
    		'display_name' => 'FINANCEIRO',
    		'description' => 'USUÁRIO COM PRIVILÉGIOS DE FINANCEIRO',
    	]);
        DB::table('roles')->insert([
            'name' => config('constantes.user_administrativo'),
            'display_name' => 'ADMINISTRATIVO',
            'description' => 'USUÁRIO COM PRIVILÉGIOS DE ADMINISTRATIVO',
        ]);
    }
}
