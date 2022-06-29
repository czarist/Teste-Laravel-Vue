<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatNacionalAvaliador extends Model
{
    use SoftDeletes;

    protected $table = 'chat_nacional_avaliador';

    protected $fillable = [
        'avaliacao_id',
        'avaliador_id',
        'coordenador_id',
        'mensagem',
        'send_avaliador',
    ];

    public function avaliacao()
    {
        return $this->belongsTo(AvaliacaoNacional::class, 'avaliacao_id');
    }

    public function coordenador()
    {
        return $this->belongsTo(CoordenadorNacional::class, 'coordenador_id');
    }

    public function avaliador()
    {
        return $this->belongsTo(User::class, 'avaliador_id');
    }
}
