<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistribuicaoTipo123 extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'avaliador_1',
        'status_avaliador_1',
        'justificativa_avaliador_1',
        'avaliador_2',
        'status_avaliador_2',
        'justificativa_avaliador_2',
        'avaliador_3',
        'status_avaliador_3',
        'justificativa_avaliador_3',
        'status_coordenador',
        'justificativa_coordenador',
        'edit',
    ];

    public function avaliador_1_obj()
    {
        return $this->hasOne(User::class, 'id', 'avaliador_1');
    }

    public function avaliador_2_obj()
    {
        return $this->hasOne(User::class, 'id', 'avaliador_2');
    }

    public function avaliador_3_obj()
    {
        return $this->hasOne(User::class, 'id', 'avaliador_3');
    }

    public function submissaoNordeste()
    {
        return $this->hasOne(SubmissaoRegionalNordestes::class, 'avaliacao', 'id');
    }

    public function submissaoSul()
    {
        return $this->hasOne(SubmissaoRegionalSul::class, 'avaliacao', 'id');
    }

    public function submissaoSudeste()
    {
        return $this->hasOne(SubmissaoRegionalSudeste::class, 'avaliacao', 'id');
    }

    public function submissaoCentroOeste()
    {
        return $this->hasOne(SubmissaoRegionalCentrooeste::class, 'avaliacao', 'id');
    }

    public function submissaoNorte()
    {
        return $this->hasOne(SubmissaoRegionalNorte::class, 'avaliacao', 'id');
    }
}
