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
        'is_avaliador_nacional_2022',
        'is_user', 
        'is_associado', 
        'is_indicado_expocom_2022',

        'is_coautor_nordeste_2022',
        'is_coautor_norte_2022',
        'is_coautor_sudeste_2022',

        'is_coautor_nordeste_expo_2022',
        'is_coautor_norte_expo_2022',
        'is_coautor_sudeste_expo_2022',

        'is_coautor_nordeste_expo_vencedor_2022',
        'is_coautor_norte_expo_vencedor_2022',
        'is_coautor_sudeste_expo_vencedor_2022',

        'avaliou_trabalho_expo_2022',
        'avaliou_trabalho_dt_2022',
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

    public function getPagoNacional2022Attribute()
    {
        if(Auth::user()){

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

    public function getIsAvaliadorNacional2022Attribute(){
        if(Auth::user()){
            $avaliador = AvaliadorExpocom::where('user_id', Auth::user()->id)
                ->where('nacional_gp', true)
                ->orWhere('nacional_ij', true)
                ->orWhere('nacional_publicom', true)
                ->first();

            if(!empty($avaliador) || $avaliador != null){
                return true;
            }
        }
        return false;
    }

    public function getIsCoautorNordeste2022Attribute(){
        if(Auth::user()){
            $coautor = CoautorOrientadorSubNordeste::where('cpf', Auth::user()->cpf)->first();

            if(isset($coautor) && !empty($coautor)){
                $submissao = SubmissaoRegionalNordestes::select('id','apresentacao')
                    ->where('id', $coautor->submissao_id)
                ->first();
            }

            if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1){
                return true;
            }
        }
        return false;
    }

    public function getIsCoautorSudeste2022Attribute(){
        if(Auth::user()){
            $coautor = CoautorOrientadorSubSudeste::where('cpf', Auth::user()->cpf)->first();

            if(isset($coautor) && !empty($coautor)){
                $submissao = SubmissaoRegionalSudeste::select('id','apresentacao')
                    ->where('id', $coautor->submissao_id)
                ->first();
            }

            if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1){
                return true;
            }
        }
        return false;
    }

    public function getIsCoautorNorte2022Attribute(){
        if(Auth::user()){
            $coautor = CoautorOrientadorSubNorte::where('cpf', Auth::user()->cpf)->first();

            if(isset($coautor) && !empty($coautor)){
                $submissao = SubmissaoRegionalNorte::select('id','apresentacao')
                    ->where('id', $coautor->submissao_id)
                ->first();
            }

            if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1){
                return true;
            }
        }
        return false;
    }

    public function getIsCoautorNordesteExpo2022Attribute(){
        if(Auth::user()){
            $coautor = CoauOriExpoSubNordeste::where('cpf', Auth::user()->cpf)->first();

            if(isset($coautor) && !empty($coautor)){
                $submissao = SubmissaoExpocomRegionalNordeste::select('id','apresentacao')
                    ->where('id', $coautor->submissao_id)
                ->first();
            }

            if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1){
                return true;
            }
        }
        return false;
    }

    public function getIsCoautorSudesteExpo2022Attribute(){
        if(Auth::user()){
            $coautor = CoauOriExpoSubSudeste::where('cpf', Auth::user()->cpf)->first();

            if(isset($coautor) && !empty($coautor)){
                $submissao = SubmissaoExpocomRegionalSudeste::select('id','apresentacao')
                    ->where('id', $coautor->submissao_id)
                ->first();
            }

            if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1){
                return true;
            }
        }
        return false;
    }

    public function getIsCoautorNorteExpo2022Attribute(){
        if(Auth::user()){
            $coautor = CoauOriExpoSubNorte::where('cpf', Auth::user()->cpf)->first();

            if(isset($coautor) && !empty($coautor)){
                $submissao = SubmissaoExpocomRegionalNorte::select('id','apresentacao')
                    ->where('id', $coautor->submissao_id)
                ->first();
            }

            if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1){
                return true;
            }
        }
        return false;
    }

    public function getIsCoautorNordesteExpoVencedor2022Attribute(){
        if(Auth::user()){
            $coautor = CoauOriExpoSubNordeste::where('cpf', Auth::user()->cpf)->first();

            if(isset($coautor) && !empty($coautor)){
                $submissao = SubmissaoExpocomRegionalNordeste::select('id','apresentacao', 'vencedor')
                    ->where('id', $coautor->submissao_id)
                ->first();
            }

            if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1){
                return true;
            }
        }
        return false;
    }

    public function getIsCoautorSudesteExpoVencedor2022Attribute(){
        if(Auth::user()){
            $coautor = CoauOriExpoSubSudeste::where('cpf', Auth::user()->cpf)->first();

            if(isset($coautor) && !empty($coautor)){
                $submissao = SubmissaoExpocomRegionalSudeste::select('id','apresentacao', 'vencedor')
                    ->where('id', $coautor->submissao_id)
                ->first();
            }

            if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1){
                return true;
            }
        }
        return false;
    }

    public function getIsCoautorNorteExpoVencedor2022Attribute(){
        if(Auth::user()){
            $coautor = CoauOriExpoSubNorte::where('cpf', Auth::user()->cpf)->first();

            if(isset($coautor) && !empty($coautor)){
                $submissao = SubmissaoExpocomRegionalNorte::select('id','apresentacao', 'vencedor')
                    ->where('id', $coautor->submissao_id)
                ->first();
            }

            if(isset($submissao) && !empty($submissao) && $submissao->apresentacao == 1 && $submissao->vencedor == 1){
                return true;
            }
        }
        return false;
    }

    public function getAvaliouTrabalhoExpo2022Attribute(){
        if(Auth::user()){
            $avaliador = AvaliadorExpocom::select('id', 'user_id', 'avaliador')
            ->where('user_id', Auth::user()->id)
            ->first();
            if(isset($avaliador) && !empty($avaliador) && $avaliador->avaliador == 1){
                $avaliacoes = DistribuicaoTipoExpocom::select('id', 'avaliador_1', 'status_avaliador_1', 'avaliador_2', 'status_avaliador_2', 'avaliador_3', 'status_avaliador_3')
                ->where('avaliador_1', $avaliador->user_id)
                ->orWhere('avaliador_2', $avaliador->user_id)
                ->orWhere('avaliador_3', $avaliador->user_id)
                ->get();

                if(isset($avaliacoes) && !empty($avaliacoes) && $avaliacoes->count() > 0){
                    foreach ($avaliacoes as $avaliacao) {
                        if($avaliacao->avaliador_1 == $avaliador->user_id && $avaliacao->status_avaliador_1 == "Avaliado" || $avaliacao->status_avaliador_1 == "Recusado"){
                            return true;
                        }
                        if($avaliacao->avaliador_2 == $avaliador->user_id && $avaliacao->status_avaliador_2 == "Avaliado" || $avaliacao->status_avaliador_2 == "Recusado"){
                            return true;
                        }
                        if($avaliacao->avaliador_3 == $avaliador->user_id && $avaliacao->status_avaliador_3 == "Avaliado" || $avaliacao->status_avaliador_3 == "Recusado"){
                            return true;
                        }
                    }
                }                 
            }
        }
        return false;
    }

    public function getAvaliouTrabalhoDt2022Attribute(){
        if(Auth::user()){
            $avaliador = AvaliadorExpocom::select('id', 'user_id', 'avaliador_junior')
            ->where('user_id', Auth::user()->id)
            ->first();
            if(isset($avaliador) && !empty($avaliador) && $avaliador->avaliador_junior == 1){
                $avaliacoes = DistribuicaoTipo123::select('id', 'avaliador_1', 'status_avaliador_1', 'avaliador_2', 'status_avaliador_2', 'avaliador_3', 'status_avaliador_3')
                ->where('avaliador_1', $avaliador->user_id)
                ->orWhere('avaliador_2', $avaliador->user_id)
                ->orWhere('avaliador_3', $avaliador->user_id)
                ->get();

                if(isset($avaliacoes) && !empty($avaliacoes) && $avaliacoes->count() > 0){
                    foreach ($avaliacoes as $avaliacao) {
                        if($avaliacao->avaliador_1 == $avaliador->user_id && $avaliacao->status_avaliador_1 == "Aceito" || $avaliacao->status_avaliador_1 == "Recusado"){
                            return true;
                        }
                        if($avaliacao->avaliador_2 == $avaliador->user_id && $avaliacao->status_avaliador_2 == "Aceito" || $avaliacao->status_avaliador_2 == "Recusado"){
                            return true;
                        }
                        if($avaliacao->avaliador_3 == $avaliador->user_id && $avaliacao->status_avaliador_3 == "Aceito" || $avaliacao->status_avaliador_3 == "Recusado"){
                            return true;
                        }
                    }
                }                 
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

    public function nacional(){
        return $this->hasOne(Nacional::class);
    }

    public function indicacao()
    {
        return $this->belongsTo(Indicacao::class, 'cpf', 'cpf_autor');
    }

    public function sexo(){
        return $this->belongsTo(Sexo::class, 'sexo_id', 'id');
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

    public function todos_gps(){
        return $this->belongsToMany(GrupoPesquisa::class, "todos_categoria_gps", "user_id", "categoria_id");
    }

}
