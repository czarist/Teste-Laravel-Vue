<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Indicacao extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome_respo',
        'cpf_respo',
        'respo_indicacao',
        'email_respo',
        'email_curso',
        'celular',
        'nome_autor',
        'cpf_autor',
        'trabalho_produzido',
        'orientador',
        'titulo_trabalho',
        'categoria',
        'endereco_id',
        'estado_id',
        'instituicao_id',
        'modalidade',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'cpf_autor', 'cpf');
    }

    public function enderecos()
    {
        return $this->hasOne(EnderecoIndicacao::class, 'id', 'endereco_id');
    }

}