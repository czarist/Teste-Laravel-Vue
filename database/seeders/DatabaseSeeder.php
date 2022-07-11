<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(ProdutoSeeder::class);
        $this->call(PagSeguroTipoFreteSeeder::class);
        $this->call(PagSeguroTipoPagtoDetalheSeeder::class);
        $this->call(PagSeguroTipoPagtoSeeder::class);
        $this->call(PagSeguroTipoStatusSeeder::class);
        $this->call(TipoSeeder::class);
        $this->call(AcessoSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AcessoUserSeeder::class);
        $this->call(TodosTiposUsersSeeder::class);
        $this->call(RelatorioSeeder::class);
    }
}
