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
                'email' => 'murilo@mercuriotecnologia.com.br',
                'password' => Hash::make('123456'),
                'data_nascimento' => '1990-01-01',
                'estrangeiro' => false,
                'cpf' => '123.456.789-01',
                'rg' => '19.205.300-5',
                'orgao_expedidor' => 'SSP',
                'telefone' => '123456789',
                'celular' => '123456789',
                'sexo_id' => 1,
            ]
        );
    }
}
