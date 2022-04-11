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

    protected $appends = [
        'is_root', 
        'is_admin', 
        'is_coordenador_2022',
        'is_avaliador_2022',
        'is_user', 
        'is_associado', 
        'anuidade_2022', 
        'pago_regional_sul_2022',
        'pago_regional_nordeste_2022',
        'pago_regional_suldeste_2022',
        'pago_regional_centrooeste_2022',
        'pago_regional_norte_2022'

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

    public function getAnuidade2022Attribute()
    {
        if(Auth::user()){

            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 5) {
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

    public function getPagoRegionalSul2022Attribute()
    {
        if(Auth::user()){

            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 6) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getPagoRegionalNordeste2022Attribute()
    {
        if(Auth::user()){

            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 7) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getPagoRegionalSuldeste2022Attribute()
    {
        if(Auth::user()){

            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 8) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getPagoRegionalCentrooeste2022Attribute()
    {
        if(Auth::user()){

            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 9) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getPagoRegionalNorte2022Attribute()
    {
        if(Auth::user()){

            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 10) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getIsIndicadoExpocom2022Attribute()
    {
        if(Auth::user()){
            $indicado = Indicacao::where('cpf_autor', Auth::user()->cpf)->first();
           if(!empty($indicado)){
                return true;
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
    
    public function getIsCoordenador2022Attribute()
    {
        if(Auth::user()){
            $coordenador = Coordenador::where('user_id', Auth::user()->id)->first();
            if(!empty($coordenador)){
                return true;
            }
        }
        return false;
    }

    public function getIsAvaliador2022Attribute()
    {
        if(Auth::user()){
            $avaliador = AvaliadorExpocom::where('user_id', Auth::user()->id)->first();
            if(!empty($avaliador)){
                return true;
            }
        }
        return false;
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

    public function avaliador_expocom(){
        return $this->hasOne(AvaliadorExpocom::class);
    }

    public function coordenador_regional(){
        return $this->hasOne(Coordenador::class);
    }

    public function regional_sul(){
        return $this->hasOne(RegionalSul::class);
    }

    public function regional_nordeste(){
        return $this->hasOne(RegionalNordeste::class);
    }

    public function regional_suldeste(){
        return $this->hasOne(RegionalSuldeste::class);
    }

    public function regional_centrooeste(){
        return $this->hasOne(RegionalCentrooeste::class);
    }

    public function regional_norte(){
        return $this->hasOne(RegionalNorte::class);
    }

    public function indicacao()
    {
        return $this->hasOne(Indicacao::class, 'cpf_autor', 'cpf');
    }


    public function todos_divisoes_tematicas()
    {
        return $this->belongsToMany(DivisoesTematicas::class, 'todos_divisoes_tematicas' , 'user_id',  'dt_id');
    }

    public function todos_divisoes_tematicas_jr()
    {
        return $this->belongsToMany(DivisoesTematicasJr::class, 'todos_divisoes_tematicas_jrs' , 'user_id',  'dt_id');
    }

    public function todos_cinema_audiovisual()
    {
        return $this->belongsToMany(CategoriaCinemaAudiovisual::class, 'todos_categoria_cinema_audiovisuals' , 'user_id',  'categoria_id');
    }

    public function todos_jornalismo()
    {
        return $this->belongsToMany(CategoriaJornalismo::class, 'todos_categoria_jornalismos' , 'user_id',  'categoria_id');
    }

    public function todos_publicidade_propaganda()
    {
        return $this->belongsToMany(CategoriaPublicidadePropaganda::class, 'todos_categoria_publicidade_propagandas' , 'user_id',  'categoria_id');
    }

    public function todos_relacoes_publicas()
    {
        return $this->belongsToMany(CategoriaRelacoesPublicas::class, 'todos_categoria_relacoes_publicas' , 'user_id',  'categoria_id');
    }

    public function todos_producao_editorial()
    {
        return $this->belongsToMany(CatProdEditProdTransComunic::class, 'todos_cat_prod_edit_trans_comunic' , 'user_id',  'categoria_id');
    }

    public function todos_radio_internet()
    {
        return $this->belongsToMany(CategoriaRadioInternet::class, 'todos_categoria_radio_internets' , 'user_id',  'categoria_id');
    }

}
