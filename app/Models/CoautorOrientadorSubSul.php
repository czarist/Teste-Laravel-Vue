<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoautorOrientadorSubSul extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'submissao_id',
        'nome_completo',
        'cpf',
        'categoria',
    ];

    public function submissao(){
        return $this->hasOne(SubmissaoRegionalSul::class, 'id', 'submissao_id');
    }
}
