<?php

namespace App\Services;

use App\Models\ChatNacional;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateChatAvaliacaoNacional
{
    public static function create($avaliacao_id, $coordenador_id, $avaliado_id, $mensagem)
    {
        return ChatNacional::create([
            'avaliacao_id' => $avaliacao_id,
            'avaliado_id' => $avaliado_id ?? null,
            'coordenador_id' => $coordenador_id ?? null,
            'mensagem' => $mensagem,
        ]);

        if (Auth::user()->id) {
            Log::info('User: '.Auth::user().' | Create conversa, avaliaçao ID: '.$avaliacao_id.'| Avaliado: '.$avaliado_id ?? null
            .' | Coordenador: '.$coordenador_id ?? null.' | Mensagem: '.$mensagem);
        }
    }

    public function __clone()
    {
        throw new Exception('Error: classe não instanciável');
    }
}
