<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedores extends Model
{
    protected $fillable = [
        'cnpj', 'razao_social', 'nome_fantasia', 'email', 'telefone', 'dados_bancarios', 'estado', 'cidade', 'bairro', 'endereco', 'CEP', 'detail'
    ];
}
