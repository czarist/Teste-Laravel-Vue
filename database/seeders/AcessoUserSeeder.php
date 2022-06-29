<?php

namespace Database\Seeders;

use App\Models\AcessoUser;
use Illuminate\Database\Seeder;

class AcessoUserSeeder extends Seeder
{
    public function run()
    {
        AcessoUser::updateOrCreate(
            ['id' => 1],
            [
                'id'  => 1,
                'acesso_id' => '1',
                'user_id' => '1',
            ]
        );

        AcessoUser::updateOrCreate(
            ['id' => 2],
            [
                'id'  => 2,
                'acesso_id' => '2',
                'user_id' => '1',
            ]
        );

        AcessoUser::updateOrCreate(
            ['id' => 3],
            [
                'id'  => 3,
                'acesso_id' => '3',
                'user_id' => '1',
            ]
        );

        AcessoUser::updateOrCreate(
            ['id' => 4],
            [
                'id'  => 4,
                'acesso_id' => '4',
                'user_id' => '1',
            ]
        );

        AcessoUser::updateOrCreate(
            ['id' => 5],
            [
                'id'  => 5,
                'acesso_id' => '5',
                'user_id' => '1',
            ]
        );
    }
}
