<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['id'=>1],
            ['id'=>1,
                'name' => 'Admin',
                'email' => "murilo@mercuriotecnologia.com.br",
                'password' => Hash::make('123456'),
                'data_nascimento' => '1990-01-01',
                'estrangeiro' => false,
                'cpf' => '12345678901',
                'rg' => '12345678901',
                'orgao_expedidor' => 'SSP',
                'telefone' => '123456789',
                'celular' => '123456789',
                'sexo_id' => 1,
                'instituicao_id' => 1,
                'titulacao_id' => 1,
                'tipo_users_id' => 1,
            ]
        );

    }
}
