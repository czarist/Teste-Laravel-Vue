<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $appends = [
        'is_root',
        'is_admin',
        'is_user',
    ];

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
        $roles = [];
        if (Auth::user()) {
            foreach (Auth::user()->acessos as $role) {
                array_push($roles, $role->link);
            }
        }

        return $roles;
    }

    public function getIsRootAttribute()
    {
        if (Auth::user()) {
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
        if (Auth::user()) {
            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 2) {
                    return true;
                }
            }
        }

        return false;
    }



    public function getIsUserAttribute()
    {
        if (Auth::user()) {
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
        if (count($parting) > 1) {
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

    public function todos_tipos_pagamentos()
    {
        return $this->belongsToMany(TipoPagamento::class, 'todos_tipos_pagamentos');
    }

    public function todos_tipos_isencao()
    {
        return $this->belongsToMany(TipoIsencao::class, 'todo_tipos_isencao');
    }

    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }

    public function associado()
    {
        return $this->hasOne(Associado::class);
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }

    public function avaliador_expocom()
    {
        return $this->hasOne(AvaliadorExpocom::class);
    }

    public function coordenador_regional()
    {
        return $this->hasOne(Coordenador::class);
    }

    public function coordenador_nacional()
    {
        return $this->hasOne(CoordenadorNacional::class);
    }

    public function regional_sul()
    {
        return $this->hasOne(RegionalSul::class);
    }

    public function regional_nordeste()
    {
        return $this->hasOne(RegionalNordeste::class);
    }

    public function regional_suldeste()
    {
        return $this->hasOne(RegionalSuldeste::class);
    }

    public function regional_centrooeste()
    {
        return $this->hasOne(RegionalCentrooeste::class);
    }

    public function regional_norte()
    {
        return $this->hasOne(RegionalNorte::class);
    }

    public function nacional()
    {
        return $this->hasOne(Nacional::class);
    }
    public function sexo()
    {
        return $this->belongsTo(Sexo::class, 'sexo_id', 'id');
    }

    public function coautor_nordeste_2022()
    {
        return $this->hasMany(CoautorOrientadorSubNordeste::class, 'cpf', 'cpf');
    }

    public function coautor_norte_2022()
    {
        return $this->hasMany(CoautorOrientadorSubNorte::class, 'cpf', 'cpf');
    }

    public function coautor_sudeste_2022()
    {
        return $this->hasMany(CoautorOrientadorSubSudeste::class, 'cpf', 'cpf');
    }

    public function coautor_sul_2022()
    {
        return $this->hasMany(CoautorOrientadorSubSul::class, 'cpf', 'cpf');
    }

    public function coautor_centrooeste_2022()
    {
        return $this->hasMany(CoautorOrientadorSubCentrooeste::class, 'cpf', 'cpf');
    }

    public function coautor_expo_nordeste_2022()
    {
        return $this->hasMany(CoauOriExpoSubNordeste::class, 'cpf', 'cpf');
    }

    public function coautor_expo_norte_2022()
    {
        return $this->hasMany(CoauOriExpoSubNorte::class, 'cpf', 'cpf');
    }

    public function coautor_expo_sul_2022()
    {
        return $this->hasMany(CoauOriExpoSubSul::class, 'cpf', 'cpf');
    }

    public function coautor_expo_sudeste_2022()
    {
        return $this->hasMany(CoauOriExpoSubSudeste::class, 'cpf', 'cpf');
    }

    public function coautor_expo_centrooeste_2022()
    {
        return $this->hasMany(CoauOriExpoSubCentrooeste::class, 'cpf', 'cpf');
    }

    public function avaliacoes_1()
    {
        return $this->hasMany(DistribuicaoTipo123::class,  'avaliador_1', 'id')
            ->whereIn('status_avaliador_1', ['Aceito', 'Recusado']);
    }

    public function avaliacoes_2()
    {
        return $this->hasMany(DistribuicaoTipo123::class,  'avaliador_2', 'id')
            ->whereIn('status_avaliador_2', ['Aceito', 'Recusado']);
    }

    public function avaliacoes_3()
    {
        return $this->hasMany(DistribuicaoTipo123::class,  'avaliador_3', 'id')
            ->whereIn('status_avaliador_3', ['Aceito', 'Recusado']);
    }

    public function avaliacoes_expo_1()
    {
        return $this->hasMany(DistribuicaoTipoExpocom::class,  'avaliador_1', 'id')
            ->whereIn('status_avaliador_1', ['Avaliado', 'Recusado']);
    }

    public function avaliacoes_expo_2()
    {
        return $this->hasMany(DistribuicaoTipoExpocom::class,  'avaliador_2', 'id')
            ->whereIn('status_avaliador_2', ['Avaliado', 'Recusado']);
    }

    public function avaliacoes_expo_3()
    {
        return $this->hasMany(DistribuicaoTipoExpocom::class,  'avaliador_3', 'id')
            ->whereIn('status_avaliador_3', ['Avaliado', 'Recusado']);
    }

    public function todos_divisoes_tematicas()
    {
        return $this->belongsToMany(DivisoesTematicas::class, 'todos_divisoes_tematicas', 'user_id', 'dt_id');
    }

    public function todos_divisoes_tematicas_jr()
    {
        return $this->belongsToMany(DivisoesTematicasJr::class, 'todos_divisoes_tematicas_jrs', 'user_id', 'dt_id');
    }

    public function todos_cinema_audiovisual()
    {
        return $this->belongsToMany(CategoriaCinemaAudiovisual::class, 'todos_categoria_cinema_audiovisuals', 'user_id', 'categoria_id');
    }

    public function todos_jornalismo()
    {
        return $this->belongsToMany(CategoriaJornalismo::class, 'todos_categoria_jornalismos', 'user_id', 'categoria_id');
    }

    public function todos_publicidade_propaganda()
    {
        return $this->belongsToMany(CategoriaPublicidadePropaganda::class, 'todos_categoria_publicidade_propagandas', 'user_id', 'categoria_id');
    }

    public function todos_relacoes_publicas()
    {
        return $this->belongsToMany(CategoriaRelacoesPublicas::class, 'todos_categoria_relacoes_publicas', 'user_id', 'categoria_id');
    }

    public function todos_producao_editorial()
    {
        return $this->belongsToMany(CatProdEditProdTransComunic::class, 'todos_cat_prod_edit_trans_comunic', 'user_id', 'categoria_id');
    }

    public function todos_radio_internet()
    {
        return $this->belongsToMany(CategoriaRadioInternet::class, 'todos_categoria_radio_internets', 'user_id', 'categoria_id');
    }

    public function todos_gps()
    {
        return $this->belongsToMany(GrupoPesquisa::class, 'todos_categoria_gps', 'user_id', 'categoria_id');
    }
}
