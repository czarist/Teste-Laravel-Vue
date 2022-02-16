<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TipoUsersSeeder::class);
        $this->call(AcessoSeeder::class);
        $this->call(TitulacaoSeeder::class);
        $this->call(SexoSeeder::class);
        $this->call(InstituicaoSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AcessoUserSeeder::class);

    }
}
