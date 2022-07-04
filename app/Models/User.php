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
        'is_coordenador_2022',
        'is_coordenador_nacional_2022',
        'is_avaliador_2022',
        'is_avaliador_nacional_2022',
        'is_user',
        'is_associado',
        'is_indicado_expocom_2022',

        'is_coautor_nordeste_2022',
        'is_coautor_norte_2022',
        'is_coautor_sudeste_2022',
        'is_coautor_sul_2022',
        'is_coautor_centrooeste_2022',

        'is_coautor_nordeste_expo_2022',
        'is_coautor_norte_expo_2022',
        'is_coautor_sudeste_expo_2022',
        'is_coautor_sul_expo_2022',
        'is_coautor_centrooeste_expo_2022',

        'is_coautor_nordeste_expo_vencedor_2022',
        'is_coautor_norte_expo_vencedor_2022',
        'is_coautor_sudeste_expo_vencedor_2022',
        'is_coautor_sul_expo_vencedor_2022',
        'is_coautor_centrooeste_expo_vencedor_2022',

        'avaliou_trabalho_expo_2022',
        'avaliou_trabalho_2022',
        'anuidade_2022',
        'pago_regional_sul_2022',
        'pago_regional_nordeste_2022',
        'pago_regional_suldeste_2022',
        'pago_regional_centrooeste_2022',
        'pago_regional_norte_2022',
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

    public function getIsAssociadoAttribute()
    {
        if (Auth::user()) {
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
        if (Auth::user()) {
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
        if (Auth::user()) {
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
        if (Auth::user()) {
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
        if (Auth::user()) {
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
        if (Auth::user()) {
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
        if (Auth::user()) {
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
        if (Auth::user()) {
            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 10) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getPagoNacional2022Attribute()
    {
        if (Auth::user()) {
            foreach (Auth::user()->todos_tipos as $tipo) {
                if ($tipo->id == 11) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsIndicadoExpocom2022Attribute()
    {
        if (Auth::user()) {
            $indicado = Indicacao::where('cpf_autor', Auth::user()->cpf)->first();
            if (! empty($indicado)) {
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
        if (count($parting) > 1) {
            $lastName = array_pop($parting);

            return $lastName;
        }
    }

    public function getIsCoordenador2022Attribute()
    {
        if (Auth::user()) {
            $coordenador = Coordenador::where('user_id', Auth::user()->id)->first();
            if (! empty($coordenador)) {
                return true;
            }
        }

        return false;
    }

    public function getIsCoordenadorNacional2022Attribute()
    {
        if (Auth::user()) {
            $coordenador = CoordenadorNacional::where('user_id', Auth::user()->id)->first();
            if (! empty($coordenador)) {
                if($coordenador && $coordenador->tipo == 1){
                   return 'coordenador_gp'; 
                }
                if($coordenador && $coordenador->tipo == 2){
                    return 'coordenador_ij'; 
                }
                if($coordenador && $coordenador->tipo == 3){
                    return 'coordenador_expocom'; 
                }
                if($coordenador && $coordenador->tipo == 4){
                    return 'coordenador_publicom'; 
                }
            }
        }

        return false;
    }
    
    public function getIsAvaliador2022Attribute()
    {
        if (Auth::user()) {
            $avaliador = AvaliadorExpocom::where('user_id', Auth::user()->id)->first();
            if (! empty($avaliador)) {
                return true;
            }
        }

        return false;
    }

    public function getIsAvaliadorNacional2022Attribute()
    {
        if (Auth::user()) {
            $avaliador = AvaliadorExpocom::where('user_id', Auth::user()->id)
                ->where('nacional_gp', true)
                ->orWhere('nacional_ij', true)
                ->orWhere('nacional_publicom', true)
                ->first();

            if (! empty($avaliador) || $avaliador != null) {
                return true;
            }
        }

        return false;
    }

    public function getIsCoautorNordeste2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoautorOrientadorSubNordeste::where('cpf', Auth::user()->cpf)->get();

            foreach ($coautores as $coautor) {
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoRegionalNordestes::select('id', 'apresentacao')
                    ->where('id', $coautor->submissao_id)
                    ->first();
                }
                
                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorSudeste2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoautorOrientadorSubSudeste::where('cpf', Auth::user()->cpf)->get();

            foreach ($coautores as $coautor) {
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoRegionalSudeste::select('id', 'apresentacao')
                    ->where('id', $coautor->submissao_id)
                    ->first();
                }
                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorNorte2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoautorOrientadorSubNorte::where('cpf', Auth::user()->cpf)->get();

            foreach ($coautores as $coautor) {
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoRegionalNorte::select('id', 'apresentacao')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }

                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorSul2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoautorOrientadorSubSul::where('cpf', Auth::user()->cpf)->get();

            foreach ($coautores as $coautor) {
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoRegionalSul::select('id', 'apresentacao')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }

                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorCentrooeste2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoautorOrientadorSubCentrooeste::where('cpf', Auth::user()->cpf)->get();

            foreach ($coautores as $coautor) {
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoRegionalCentrooeste::select('id', 'apresentacao')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }

                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorNordesteExpo2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoauOriExpoSubNordeste::where('cpf', Auth::user()->cpf)->get();

            foreach ($coautores as $coautor) {
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoExpocomRegionalNordeste::select('id', 'apresentacao')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }

                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorSudesteExpo2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoauOriExpoSubSudeste::where('cpf', Auth::user()->cpf)->get();

            foreach ($coautores as $coautor) {
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoExpocomRegionalSudeste::select('id', 'apresentacao')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }

                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorNorteExpo2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoauOriExpoSubNorte::where('cpf', Auth::user()->cpf)->get();

            foreach ($coautores as $coautor) {
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoExpocomRegionalNorte::select('id', 'apresentacao')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }

                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorSulExpo2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoauOriExpoSubSul::where('cpf', Auth::user()->cpf)->get();

            foreach ($coautores as $coautor) {
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoExpocomRegionalSul::select('id', 'apresentacao')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }

                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorCentrooesteExpo2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoauOriExpoSubCentrooeste::where('cpf', Auth::user()->cpf)->get();

            foreach ($coautores as $coautor) {
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoExpocomRegionalCentrooeste::select('id', 'apresentacao')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }

                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorNordesteExpoVencedor2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoauOriExpoSubNordeste::where('cpf', Auth::user()->cpf)->get();

            foreach ($coautores as $coautor) {
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoExpocomRegionalNordeste::select('id', 'apresentacao', 'vencedor')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }

                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorSudesteExpoVencedor2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoauOriExpoSubSudeste::where('cpf', Auth::user()->cpf)->get();

            foreach($coautores as $coautor){
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoExpocomRegionalSudeste::select('id', 'apresentacao', 'vencedor')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }
                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorNorteExpoVencedor2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoauOriExpoSubNorte::where('cpf', Auth::user()->cpf)->get();

            foreach($coautores as $coautor){
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoExpocomRegionalNorte::select('id', 'apresentacao', 'vencedor')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }

                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsCoautorSulExpoVencedor2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoauOriExpoSubSul::where('cpf', Auth::user()->cpf)->get();

            foreach($coautores as $coautor){
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoExpocomRegionalSul::select('id', 'apresentacao', 'vencedor')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }

                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1) {
                    return true;
                }
            }

        }

        return false;
    }

    public function getIsCoautorCentrooesteExpoVencedor2022Attribute()
    {
        if (Auth::user()) {
            $coautores = CoauOriExpoSubCentrooeste::where('cpf', Auth::user()->cpf)->get();

            foreach($coautores as $coautor){
                if (isset($coautor) && ! empty($coautor)) {
                    $submissao = SubmissaoExpocomRegionalCentrooeste::select('id', 'apresentacao', 'vencedor')
                        ->where('id', $coautor->submissao_id)
                    ->first();
                }

                if (isset($submissao) && ! empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getAvaliouTrabalhoExpo2022Attribute()
    {
        if (Auth::user()) {
            $avaliacoes = DistribuicaoTipoExpocom::select('id', 'avaliador_1', 'status_avaliador_1', 'avaliador_2', 'status_avaliador_2', 'avaliador_3', 'status_avaliador_3')
            ->with('submissaoNorte', 'submissaoNordeste', 'submissaoSul', 'submissaoSudeste', 'submissaoCentroOeste')
            ->where('avaliador_1',Auth::user()->id)
            ->orWhere('avaliador_2',Auth::user()->id)
            ->orWhere('avaliador_3',Auth::user()->id)
            ->get();
    
            if (isset($avaliacoes) && ! empty($avaliacoes) && $avaliacoes->count() > 0) {
                $avaliou = [];
    
                foreach ($avaliacoes as $avaliacao) {
                    if ($avaliacao->avaliador_1 == Auth::user()->id && $avaliacao->status_avaliador_1 == 'Avaliado' || $avaliacao->avaliador_1 == Auth::user()->id && $avaliacao->status_avaliador_1 == 'Recusado'
                    || $avaliacao->avaliador_2 == Auth::user()->id && $avaliacao->status_avaliador_2 == 'Avaliado' || $avaliacao->avaliador_2 == Auth::user()->id && $avaliacao->status_avaliador_2 == 'Recusado'
                    || $avaliacao->avaliador_3 == Auth::user()->id && $avaliacao->status_avaliador_3 == 'Avaliado' || $avaliacao->avaliador_3 == Auth::user()->id && $avaliacao->status_avaliador_3 == 'Recusado'
                    ) {
                        if($avaliacao && $avaliacao->submissaoCentroOeste) {
                            $avaliou[] = 'centrooeste';
                        }
                        if($avaliacao && $avaliacao->submissaoNordeste) {
                            $avaliou[] = 'nordeste';
                        }
                        if($avaliacao && $avaliacao->submissaoNorte) {
                            $avaliou[] = 'norte';
                        }
                        if($avaliacao && $avaliacao->submissaoSudeste) {
                            $avaliou[] = 'sudeste';
                        }
                        if($avaliacao && $avaliacao->submissaoSul) {
                            $avaliou[] = 'sul';
                        }
                    }
                }
                $avaliou = array_unique($avaliou);
    
                if (in_array('', $avaliou)) {                    
                    return false;
                }    
                return $avaliou;
            }
        }
    
        return false;
        }

    public function getAvaliouTrabalho2022Attribute()
    {
        if (Auth::user()) {
            $avaliacoes = DistribuicaoTipo123::select('id', 'avaliador_1', 'status_avaliador_1', 'avaliador_2', 'status_avaliador_2', 'avaliador_3', 'status_avaliador_3')
            ->with('submissaoNorte', 'submissaoNordeste', 'submissaoSul', 'submissaoSudeste', 'submissaoCentroOeste')
            ->where('avaliador_1',Auth::user()->id)
            ->orWhere('avaliador_2',Auth::user()->id)
            ->orWhere('avaliador_3',Auth::user()->id)
            ->get();

            if (isset($avaliacoes) && ! empty($avaliacoes) && $avaliacoes->count() > 0) {
                $avaliou = [];

                foreach ($avaliacoes as $avaliacao) {
                    if ($avaliacao->avaliador_1 == Auth::user()->id && $avaliacao->status_avaliador_1 == 'Aceito' || $avaliacao->avaliador_1 == Auth::user()->id && $avaliacao->status_avaliador_1 == 'Recusado'
                    || $avaliacao->avaliador_2 == Auth::user()->id && $avaliacao->status_avaliador_2 == 'Aceito' || $avaliacao->avaliador_2 == Auth::user()->id && $avaliacao->status_avaliador_2 == 'Recusado'
                    || $avaliacao->avaliador_3 == Auth::user()->id && $avaliacao->status_avaliador_3 == 'Aceito' || $avaliacao->avaliador_3 == Auth::user()->id && $avaliacao->status_avaliador_3 == 'Recusado'
                    ) {
                        if($avaliacao && $avaliacao->submissaoCentroOeste) {
                            $avaliou[] = 'centrooeste';
                        }
                        if($avaliacao && $avaliacao->submissaoNordeste) {
                            $avaliou[] = 'nordeste';
                        }
                        if($avaliacao && $avaliacao->submissaoNorte) {
                            $avaliou[] = 'norte';
                        }
                        if($avaliacao && $avaliacao->submissaoSudeste) {
                            $avaliou[] = 'sudeste';
                        }
                        if($avaliacao && $avaliacao->submissaoSul) {
                            $avaliou[] = 'sul';
                        }
                    }
                }
                $avaliou = array_unique($avaliou);

                if (in_array('', $avaliou)) {                    
                    return false;
                }    

                return $avaliou;
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

    public function indicacao()
    {
        return $this->belongsTo(Indicacao::class, 'cpf', 'cpf_autor');
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
