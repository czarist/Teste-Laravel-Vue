<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissaoRegionalSulController extends Controller
{
    public function usuario(){
        return User::select('id', 'name')
            ->with('acessos:id,pagina,link',
                'todos_tipos:id,descricao',
                'todos_divisoes_tematicas:id,descricao',
                'todos_divisoes_tematicas_jr:id,descricao',
                'todos_cinema_audiovisual:id,descricao',
                'todos_jornalismo:id,descricao',
                'todos_publicidade_propaganda:id,descricao',
                'todos_relacoes_publicas:id,descricao',
                'todos_producao_editorial:id,descricao',
                'todos_radio_internet:id,descricao',
                'regional_sul',
                'regional_sul.submissao'
                )
                ->find(Auth::user()->id);
    }

    public function submissaoRegionalSul(){
        $user = $this->usuario();
        $regiao = 1;

        return view('regionais.sul.submissao', compact('user', 'regiao'));
    }

}
