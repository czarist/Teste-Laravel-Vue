<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\PagSeguroTipoFrete;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(TipoSeeder::class);
        $this->call(AcessoSeeder::class);
        $this->call(TitulacaoSeeder::class);
        $this->call(SexoSeeder::class);
        $this->call(InstituicaoSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AcessoUserSeeder::class);
        $this->call(TodosTiposUsersSeeder::class);

        $this->call(PagSeguroPagtoLinkSeeder::class);
        $this->call(PagSeguroPgtoSeeder::class);
        $this->call(PagSeguroTipoFreteSeeder::class);
        $this->call(PagSeguroTipoPagtoDetalheSeeder::class);
        $this->call(PagSeguroTipoPagtoSeeder::class);
        $this->call(PagSeguroTipoStatusSeeder::class);

        $this->call(ProdutoSeeder::class);
    }
}
