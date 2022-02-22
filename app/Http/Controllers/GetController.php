<?php

namespace App\Http\Controllers;

use App\Models\Acesso;
use App\Models\TipoUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetController extends Controller
{
    public function userlogado(User $user)
    {
        return $user::select('id', 'name', 'email', 'password', 'tipo_users_id', 'created_at')
            ->with(
                'acessos',
                'tipo_user:id,descricao'
            )
            ->find(Auth::user()->id);
    }

    public function getUsers(User $user)
    {
        return $user->select('id','name', 'ativo')->orderBy('name')->get();
    }

    
    public function tiposUsuarios(TipoUsers $tipoUser)
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
}
