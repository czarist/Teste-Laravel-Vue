<?php

namespace Database\Seeders;

use App\Models\TodosTiposUsers;
use Illuminate\Database\Seeder;

class TodosTiposUsersSeeder extends Seeder
{
    public function run()
    {
        TodosTiposUsers::updateOrCreate(
            ['id' => 1],
            [
                'id'  => 1,
                'tipo_id' => '1',
                'user_id' => '1',
            ]
        );

        TodosTiposUsers::updateOrCreate(
            ['id' => 2],
            [
                'id'  => 2,
                'tipo_id' => '2',
                'user_id' => '1',
            ]
        );

        TodosTiposUsers::updateOrCreate(
            ['id' => 3],
            [
                'id'  => 3,
                'tipo_id' => '3',
                'user_id' => '1',
            ]
        );

        TodosTiposUsers::updateOrCreate(
            ['id' => 4],
            [
                'id'  => 4,
                'tipo_id' => '4',
                'user_id' => '1',
            ]
        );
    }
}
