<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nacional extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'presenca',
        'categoria_inscricao',
        'numero_matricula',
        'ano',
        'guardador_sabado',
        'port_nece_espe',
        'port_nece_espe_qual',
        'port_nece_espe_outra',
    ];

    public function submissaoPublicom()
    {
        return $this->hasOne(SubmissaoNacional::class, 'inscricao_id', 'id')->whereTipo('Publicom');
    }

    public function submissaoGp()
    {
        return $this->hasOne(SubmissaoNacional::class, 'inscricao_id', 'id')->whereTipo('Grupo de Pesquisa');
    }

    public function submissaoJunior()
    {
        return $this->hasOne(SubmissaoNacional::class, 'inscricao_id', 'id')->whereTipo('Intercom Júnior');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
