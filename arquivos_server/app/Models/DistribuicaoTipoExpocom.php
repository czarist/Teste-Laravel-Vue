<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DistribuicaoTipoExpocom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'avaliador_1',
        'status_avaliador_1',
        'justificativa_avaliador_1',
        'expe_1',
        'qualidade_1',
        'coerencia_1',
        'media_1',
        'avaliador_2',
        'status_avaliador_2',
        'justificativa_avaliador_2',
        'expe_2',
        'qualidade_2',
        'coerencia_2',
        'media_2',
        'avaliador_3',
        'status_avaliador_3',
        'justificativa_avaliador_3',
        'expe_3',
        'qualidade_3',
        'coerencia_3',
        'media_3',
        'status_coordenador',
        'justificativa_coordenador',
        'edit',
        'media_final'
    ];

    public function avaliador_1_obj(){
        return $this->hasOne(User::class, 'id', 'avaliador_1');
    }

    public function avaliador_2_obj(){
        return $this->hasOne(User::class, 'id', 'avaliador_2');
    }

    public function avaliador_3_obj(){
        return $this->hasOne(User::class, 'id', 'avaliador_3');
    }

    public function submissaoNordeste(){
        return $this->hasOne(SubmissaoExpocomRegionalNordeste::class, 'avaliacao', 'id');
    }

    public function submissaoSul(){
        return $this->hasOne(SubmissaoExpocomRegionalSul::class, 'avaliacao', 'id');
    }

    public function submissaoSudeste(){
        return $this->hasOne(SubmissaoExpocomRegionalSudeste::class, 'avaliacao', 'id');
    }

    public function submissaoCentroOeste(){
        return $this->hasOne(SubmissaoExpocomRegionalCentrooeste::class, 'avaliacao', 'id');
    }

    public function submissaoNorte(){
        return $this->hasOne(SubmissaoExpocomRegionalNorte::class, 'avaliacao', 'id');
    }

    public function submissaoExpocomNordeste(){
        return $this->hasOne(SubmissaoExpocomRegionalNordeste::class, 'avaliacao', 'id');
    }

    public function submissaoExpocomSul(){
        return $this->hasOne(SubmissaoExpocomRegionalSul::class, 'avaliacao', 'id');
    }

    public function submissaoExpocomSudeste(){
        return $this->hasOne(SubmissaoExpocomRegionalSudeste::class, 'avaliacao', 'id');
    }

    public function submissaoExpocomCentrooeste(){
        return $this->hasOne(SubmissaoExpocomRegionalCentrooeste::class, 'avaliacao', 'id');
    }

    public function submissaoExpocomNorte(){
        return $this->hasOne(SubmissaoExpocomRegionalNorte::class, 'avaliacao', 'id');
    }

}
