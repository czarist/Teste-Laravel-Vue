<?php

namespace App\Services;

use App\Models\ChatAvaliacao;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class CreateChatAvaliacao
{
    public static function create($avaliacao_id, $avaliado_id, $avaliador_id, $coordenador_id, $mensagem)
    {
        return ChatAvaliacao::create([
            'avaliacao_id' => $avaliacao_id,
            'avaliado_id' => $avaliado_id ?? null,
            'avaliador_id' => $avaliador_id ?? null,
            'coordenador_id' => $coordenador_id ?? null,
            'mensagem' => $mensagem,
        ]);

        if(Auth::user()->id){
            Log::info('User: '.Auth::user(). ' | Create conversa, avaliaçao ID: '. $avaliacao_id . ' | Avaliado: '. $avaliado_id ?? null . ' | Avaliador: '. $avaliador_id ?? null
            . ' | Coordenador: '. $coordenador_id ?? null . ' | Mensagem: '. $mensagem );
        }
    }

    public function __clone()
    {
        throw new Exception('Error: classe não instanciável');
    }
}
