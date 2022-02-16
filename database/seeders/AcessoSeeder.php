<?php

namespace Database\Seeders;

use App\Models\Acesso;
use Illuminate\Database\Seeder;

class AcessoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Acesso::updateOrCreate(
            ['id' => 1],
            [
                'id'  => 1,
                'pagina' => 'Analytics',
                'link' => 'analytics'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 2],
            [
                'id'  => 2,
                'pagina' => 'Sales',
                'link' => 'sales'
            ]
        );

        Acesso::updateOrCreate(
            ['id' => 3],
            [
                'id'  => 3,
                'pagina' => 'Apps',
                'link' => 'apps'
            ]
        );


    }
}
