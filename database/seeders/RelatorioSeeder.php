<?php

namespace Database\Seeders;

use App\Models\PagSeguroPgto;
use App\Models\User;
use App\Models\Venda;
use App\Models\VendaItem;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RelatorioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Popular Post
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => Str::random(20),
                'email' => Str::random(20),
                'password' => Hash::make('123456'),
                'data_nascimento' => '1990-01-01',
                'estrangeiro' => false,
                'cpf' => Str::random(11),
                'rg' => '19.205.300-5',
                'orgao_expedidor' => 'SSP',
                'telefone' => '123456789',
                'celular' => '123456789',
            ]);

            $venda = Venda::create([
                'user_id' => $user->id,                
            ]);

            $venda_item = VendaItem::create([
                'qtd' => 1,
                'valor' => 100.00,
                'valor_total' => 100.00,
                'venda_id' => $venda->id,
                'produto_id' => 1
            ]);

            $pagamento = PagSeguroPgto::create([
                'tipo_pgto_detalhe' => 101,
                'transacao' => '9EF758EA-CF00-4D26-8762-CCA7AAF121AC',
                'parcelas' => 1,
                'valor_parcela' => $venda_item->valor,
                'valor_total' => $venda_item->valor,
                'valor_juros' => 0,
                'valor_receber' => $venda_item->valor,
                'venda_id' => $venda->id,
                'tipo_pagto_id' => 1,
                'status_id' => 4,
                'user_id' => $user->id
            ]);

            $todos_tipos = [0 => 1];
            $user->todos_tipos()->attach($todos_tipos);

            $todos_tipos_pagamentos = [0 => 1];
            $user->todos_tipos_pagamentos()->attach($todos_tipos_pagamentos);

        }
    }
}
