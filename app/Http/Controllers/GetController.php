<?php

namespace App\Http\Controllers;

use App\Models\Instituicao;
use App\Models\Acesso;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Produto;
use App\Models\Sexo;
use App\Models\Tipo;
use App\Models\Titulacao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetController extends Controller
{
    public function userlogado(User $user)
    {
        return $user::select('id', 'name', 'email', 'password', 'created_at')
            ->with('acessos','todos_tipos')->find(Auth::user()->id);
    }

    public function getUsers(User $user)
    {
        return $user->select('id','name', 'ativo')->orderBy('name')->get();
    }

    public function getTitulacoes(Titulacao $user)
    {
        return $user->select('id','titulacao')->orderBy('titulacao')->get();
    }

    public function getInstituicoes(Instituicao $user)
    {
        return $user->select('id','instituicao', 'sigla_instituicao')->orderBy('instituicao')->get();
    }

    
    public function tiposUsuarios(Tipo $tipoUser)
    {
        return $tipoUser->select('descricao', 'id')->orderBy('descricao')->get();
    }

    public function acessos(Acesso $acesso)
    {
        if (!Auth::user()->is_root && !Auth::user()->is_admin) {
            return abort(403);
        }
        return $acesso->select('pagina', 'id')->orderBy('pagina')->get();
    }

    public function getEstados(Estado $estado)
    {
        return $estado->select('nome', 'sigla', 'id')->orderBy('sigla')->get();
    }

    public function getMunicipios(Municipio $municipio, $estado_id)
    {
        return $municipio->select('nome', 'id')->whereEstadoId($estado_id)->orderBy('nome')->get();
    }

    public function getTipoSexo(Sexo $sexo)
    {
        return $sexo->select('tipo_sexo', 'id')->orderBy('tipo_sexo')->get();
    }

    public function getProdutos(Produto $produtos)
    {
        return $produtos->select('id', 'nome', 'valor')->orderBy('nome')->get();
    }

}
