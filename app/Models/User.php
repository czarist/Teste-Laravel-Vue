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
    protected $appends = ['is_root', 'is_admin', 'is_user', 'is_associado'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'data_nascimento',
        'estrangeiro',
        'passaporte',
        'cpf',
        'rg',
        'orgao_expedidor',
        'telefone',
        'celular',
        'sexo_id',
        'ativo',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

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
        if(Auth::user()){

            foreach (Auth::user()->acessos as $role) {
                array_push($roles, $role->link);
            };
        }
        return $roles;
    }

    public function getIsRootAttribute()
    {

        if(Auth::user()){

            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 1) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getIsAdminAttribute()
    {
        if(Auth::user()){

            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 2) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getIsAssociadoAttribute()
    {
        if(Auth::user()){

            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 3) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getIsUserAttribute()
    {
        if(Auth::user()){

            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 4) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getFirstNameAttribute()
    {
        $parting = explode(' ', $this->name);
        $firstName = array_shift($parting);
        return $firstName;
    }

    public function getLastNameAttribute()
    {
        $parting = explode(' ', $this->name);
        if(count($parting) > 1) {
            $lastName = array_pop($parting);
            return $lastName;
        }
    }    



    public function acessos()
    {
        return $this->belongsToMany(Acesso::class);
    }

    public function todos_tipos()
    {
        return $this->belongsToMany(Tipo::class, 'todos_tipos_users');
    }

    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }

    public function associado()
    {
        return $this->hasOne(Associado::class);
    }

    public function vendas(){
        return $this->hasMany(Venda::class);
    }

    
}
