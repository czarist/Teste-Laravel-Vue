<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatNacional extends Model
{
    use SoftDeletes;

    protected $table = 'chat_nacional';

    protected $fillable = [
        'avaliacao_id',
        'avaliado_id',
        'coordenador_id',
        'mensagem',
    ];

    public function avaliacao()
    {
        return $this->belongsTo(AvaliacaoNacional::class, 'avaliacao_id');
    }

    public function coordenador()
    {
        return $this->belongsTo(CoordenadorNacional::class, 'coordenador_id');
    }

    public function avaliado()
    {
        return $this->belongsTo(User::class, 'avaliado_id');
    }
}
