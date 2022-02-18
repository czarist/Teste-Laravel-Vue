<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Auth;
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'data_nascimento',
        'estrangeiro',
        'cpf',
        'rg',
        'orgao_expedidor',
        'telefone',
        'celular',
        'sexo_id',
        'instituicao_id',
        'titulacao_id',
        'tipo_users_id',
        'ativo',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) || abort(403, 'Acesso negado.');
        }
        return $this->hasRole($roles) || abort(403, 'Acesso negado.');
    }

    public function hasAnyRole($roles)
    {
        return null !== $this->acessos()->whereIn('link', $roles)->first();
    }

    public function hasRole($role)
    {
        return null !== $this->acessos()->whereLink($role)->first();
    }

    public function roles()
    {
        $roles = array();
        foreach (Auth::user()->acessos as $role) {
            array_push($roles, $role->link);
        };
        return $roles;
    }

    public function getIsRootAttribute()
    {
        return $this->tipo_user_id == 1;
    }

    public function getIsAdminAttribute()
    {
        return $this->tipo_user_id == 2;
    }

    public function getIsAssociadoAttribute()
    {
        return $this->tipo_user_id == 2;
    }

    public function getIsUserAttribute()
    {
        return $this->tipo_user_id == 2;
    }

    public function acessos()
    {
        return $this->belongsToMany(Acesso::class);
    }

    public function tipo_users()
    {
        return $this->belongsTo(TipoUsers::class);
    }
}
