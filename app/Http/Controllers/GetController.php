<?php

namespace App\Http\Controllers;

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
                'tipo_users:id,descricao'
            )
            ->find(Auth::user()->id);
    }
}
