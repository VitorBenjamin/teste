<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(AreaAtuacaoTableSeeder::class);
        $this->call(UnidadeTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(TipoGuiaTableSeeder::class);
        //$this->call(ClienteTableSeeder::class);
        //$this->call(SolicitanteTableSeeder::class);
        $this->call(UserTableSeeder::class);
        //$this->call(ProcessoTableSeeder::class);
        $this->call(RoleTableSeeder::class);

        // $this->call([
        //     AreaAtuacaoTableSeeder::class,
        //     UnidadeTableSeeder::class,
        //     StatusTableSeeder::class,
        //     TipoGuiaTableSeeder::class,
        //     ClienteTableSeeder::class,
        //     SolicitanteTableSeeder::class,
        //     UserTableSeeder::class,
        // ]);
        //factory(App\Unidade::class, 20)->create();
    }
}

