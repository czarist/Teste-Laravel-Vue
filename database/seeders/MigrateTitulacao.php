<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class MigrateTitulacao extends Seeder
{
    public function run()
    {
        $users = User::with(
            'associado',
            'nacional',
            'regional_sul',
            'regional_centrooeste',
            'regional_nordeste',
            'regional_norte',
            'regional_suldeste'
        )
        ->get();

        foreach ($users as $user) {
            if ($user && $user->associado != null) {
                if ($user && $user->nacional && $user->nacional->categoria_inscricao && $user->nacional->categoria_inscricao != null) {
                    $user->associado->titulacao_id = $user->nacional->categoria_inscricao;
                    $user->associado->save();
                }

                if ($user && $user->regional_sul && $user->regional_sul->categoria_inscricao && $user->regional_sul->categoria_inscricao != null) {
                    $user->associado->titulacao_id = $user->regional_sul->categoria_inscricao;
                    $user->associado->save();
                }

                if ($user && $user->regional_centrooeste && $user->regional_centrooeste->categoria_inscricao && $user->regional_centrooeste->categoria_inscricao != null) {
                    $user->associado->titulacao_id = $user->regional_centrooeste->categoria_inscricao;
                    $user->associado->save();
                }

                if ($user && $user->regional_nordeste && $user->regional_nordeste->categoria_inscricao && $user->regional_nordeste->categoria_inscricao != null) {
                    $user->associado->titulacao_id = $user->regional_nordeste->categoria_inscricao;
                    $user->associado->save();
                }

                if ($user && $user->regional_norte && $user->regional_norte->categoria_inscricao && $user->regional_norte->categoria_inscricao != null) {
                    $user->associado->titulacao_id = $user->regional_norte->categoria_inscricao;
                    $user->associado->save();
                }

                if ($user && $user->regional_suldeste && $user->regional_suldeste->categoria_inscricao && $user->regional_suldeste->categoria_inscricao != null) {
                    $user->associado->titulacao_id = $user->regional_suldeste->categoria_inscricao;
                    $user->associado->save();
                }
            }
        }
    }
}
