<?php

namespace Database\Seeders;

use App\Models\AcessoUser;
use Illuminate\Database\Seeder;

class AcessoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcessoUser::updateOrCreate(
            ['id' => 1],
            [
                'id'  => 1,
                'acesso_id' => '1',
                'user_id' => '1'
            ]
        );

        AcessoUser::updateOrCreate(
            ['id' => 2],
            [
                'id'  => 2,
                'acesso_id' => '2',
                'user_id' => '1'
            ]
        );

    }
}
