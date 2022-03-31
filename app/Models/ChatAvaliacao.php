<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatAvaliacao extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'avaliacao_id',
        'avaliado_id',
        'avaliador_id',
        'coordenador_id',
        'mensagem',
    ];

    public function avaliacao()
    {
        return $this->belongsTo(DistribuicaoTipo123::class, 'avaliacao_id');
    }

    public function coordenador()
    {
        return $this->belongsTo(Coordenador::class, 'coordenador_id');
    }

    public function avaliador()
    {
        return $this->belongsTo(User::class, 'avaliador_id');
    }

    public function avaliado()
    {
        return $this->belongsTo(User::class, 'avaliado_id');
    }
}
