<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoautorOrientadorSubNordeste extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'submissao_id',
        'nome_completo',
        'cpf',
        'categoria',
    ];

    public function submissao(){
        return $this->hasOne(SubmissaoRegionalNordestes::class, 'id', 'submissao_id');
    }
}
