<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegionalCentrooeste extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'regiao',
        'presenca',
        'categoria_inscricao',
        'numero_matricula',
        'ano',
        'guardador_sabado',
        'port_nece_espe',
        'port_nece_espe_qual',
        'port_nece_espe_outra',
    ];

    public function submissaoMesa()
    {
        return $this->hasOne(SubmissaoRegionalCentrooeste::class, 'inscricao_id', 'id')->whereTipo('Mesa');
    }

    public function submissaoDt()
    {
        return $this->hasOne(SubmissaoRegionalCentrooeste::class, 'inscricao_id', 'id')->whereTipo('Divisões Temáticas');
    }

    public function submissaoJunior()
    {
        return $this->hasOne(SubmissaoRegionalCentrooeste::class, 'inscricao_id', 'id')->whereTipo('Intercom Júnior');
    }

    public function submissaoExpocom()
    {
        return $this->hasOne(SubmissaoExpocomRegionalCentrooeste::class, 'inscricao_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
