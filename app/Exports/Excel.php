<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class Excel implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('id', 'name', 'email', 'cpf', 'sexo_id', 'telefone', 'celular', 'deleted_at')
        ->with(
            'sexo:id,tipo_sexo',
            'associado:id,instituicao_id,titulacao_id,anuidade',
            'associado.instituicao:id,instituicao,sigla_instituicao',
            'associado.titulacao:id,titulacao',
            'vendas:id,user_id',
            'vendas.vendas_item:id,venda_id,produto_id',
            'vendas.vendas_item.produto:id,categoria,nome,valor',
            'vendas.pagamento:id,venda_id,status_id,user_id',
            'todos_tipos',
            'regional_nordeste:id,user_id,regiao,guardador_sabado,port_nece_espe,port_nece_espe_qual,port_nece_espe_outra'
        )
            ->whereHas('todos_tipos', function ($query) {
                $query->where('tipo_id', 7);
            })

        ->get();
    }
}
