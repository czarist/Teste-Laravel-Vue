<?php

namespace App\Http\Controllers;

use App\Models\Acesso;
use App\Models\CategoriaCinemaAudiovisual;
use App\Models\CategoriaJornalismo;
use App\Models\CategoriaPublicidadePropaganda;
use App\Models\CategoriaRadioInternet;
use App\Models\CategoriaRelacoesPublicas;
use App\Models\CatProdEditProdTransComunic;
use App\Models\Coordenador;
use App\Models\DivisoesTematicas;
use App\Models\DivisoesTematicasJr;
use App\Models\Estado;
use App\Models\GrupoPesquisa;
use App\Models\Indicacao;
use App\Models\Instituicao;
use App\Models\Municipio;
use App\Models\PagSeguroTipoStatus;
use App\Models\Produto;
use App\Models\Sexo;
use App\Models\Tipo;
use App\Models\TipoIsencao;
use App\Models\Titulacao;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GetController extends Controller
{
    public function userlogado(User $user)
    {
        if (Auth::user() && Auth::user()->id) {
            $user_id = Auth::user()->id;
        }

        if (! empty($user_id)) {
            return $user::select('id', 'name', 'email', 'password', 'created_at')
                ->with('acessos', 'todos_tipos')
            ->findOrFail($user_id);
        }
    }

    public function getUsers(User $user)
    {
        return $user->select('id', 'name', 'ativo')->orderBy('name')->get();
    }

    public function getTitulacoes(Titulacao $user)
    {
        return $user->select('id', 'titulacao')->orderBy('titulacao')->get();
    }

    public function getInstituicoes(Instituicao $user)
    {
        return $user->select('id', 'instituicao', 'sigla_instituicao')->orderBy('instituicao')->get();
    }

    public function tiposUsuarios(Tipo $tipoUser)
    {
        return $tipoUser->select('descricao', 'id')->orderBy('descricao')->get();
    }

    public function tipo_isencao(TipoIsencao $tipo_isencao)
    {
        return $tipo_isencao->select('descricao', 'id')->orderBy('descricao')->get();
    }

    public function acessos(Acesso $acesso)
    {
        if (! Auth::user()->is_root && ! Auth::user()->is_admin) {
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

    public function getDivisoesTematicas(DivisoesTematicas $divisoesTematicas)
    {
        return $divisoesTematicas->select('id', 'dt', 'descricao')->get();
    }

    public function getGrupoPesquisa(GrupoPesquisa $gp)
    {
        return $gp->select('id', 'gp', 'descricao')->get();
    }

    public function getDivisoesTematicasJr(DivisoesTematicasJr $divisoesTematicasJr)
    {
        return $divisoesTematicasJr->select('id', 'dt', 'descricao')->get();
    }

    public function getCinemaAudiovisual(CategoriaCinemaAudiovisual $categoriaCinemaAudiovisual)
    {
        return $categoriaCinemaAudiovisual->select('id', 'descricao')->get();
    }

    public function getJornalismo(CategoriaJornalismo $categoriaJornalismo)
    {
        return $categoriaJornalismo->select('id', 'descricao')->get();
    }

    public function getPublicidadePropaganda(CategoriaPublicidadePropaganda $categoriaPublicidadePropaganda)
    {
        return $categoriaPublicidadePropaganda->select('id', 'descricao')->get();
    }

    public function getRelacoesPublicas(CategoriaRelacoesPublicas $categoriaRelacoesPublicas)
    {
        return $categoriaRelacoesPublicas->select('id', 'descricao')->get();
    }

    public function getProdEdit(CatProdEditProdTransComunic $catProdEditProdTransComunic)
    {
        return $catProdEditProdTransComunic->select('id', 'descricao')->get();
    }

    public function getRadioInternet(CategoriaRadioInternet $categoriaRadioInternet)
    {
        return $categoriaRadioInternet->select('id', 'descricao')->get();
    }

    public function getProdutosRegionaisSul(Produto $produtos)
    {
        return $produtos->select('id', 'categoria', 'nome', 'valor')->whereCategoria('Regional-Sul')->get();
    }

    public function getProdutosRegionaisSuldeste(Produto $produtos)
    {
        return $produtos->select('id', 'categoria', 'nome', 'valor')->whereCategoria('Regional-Suldeste')->get();
    }

    public function getProdutosRegionaisNorte(Produto $produtos)
    {
        return $produtos->select('id', 'categoria', 'nome', 'valor')->whereCategoria('Regional-Norte')->get();
    }

    public function getProdutosRegionaisNordeste(Produto $produtos)
    {
        return $produtos->select('id', 'categoria', 'nome', 'valor')->whereCategoria('Regional-Nordeste')->get();
    }

    public function getProdutosRegionaisCentrooeste(Produto $produtos)
    {
        return $produtos->select('id', 'categoria', 'nome', 'valor')->whereCategoria('Regional-Centro-Oeste')->get();
    }

    public function getProdutosNacional(Produto $produtos)
    {
        return $produtos->select('id', 'categoria', 'nome', 'valor')->whereCategoria('Nacional')->get();
    }

    public function getProdutosRegionais(Produto $produtos)
    {
        return $produtos->select('id', 'categoria', 'nome', 'valor')->get();
    }

    public function getIndicacaoExpocom2022(Indicacao $indicacao)
    {

        // return $indicacao::with('enderecos', 'enderecos.municipio', 'enderecos.municipio.estado')->where('cpf_autor', Auth::user()->cpf)->first();

        if (Auth::user() && Auth::user()->cpf) {
            return $indicacao::with('enderecos', 'enderecos.municipio', 'enderecos.municipio.estado')->where('cpf_autor', Auth::user()->cpf)->first();

            if (! empty($indicacao) && $indicacao->cpf_autor) {
                return $indicacao;
            } else {
                return response()->json(['error' => 'Nenhuma indicação encontrada'], 404);
            }
        }

        return response()->json(['error' => 'Sem usuario logado'], 404);
    }

    public function getAdminIndicacaoExpocom2022($id, Indicacao $indicacao)
    {
        return $indicacao::with('enderecos', 'enderecos.municipio', 'enderecos.municipio.estado')->findOrFail($id);
    }

    public function getAvaliadores(User $user)
    {
        return $user->select('id', 'name')
                    ->with(
                        'avaliador_expocom',
                        'todos_divisoes_tematicas:id,descricao',
                        'todos_divisoes_tematicas_jr:id,descricao',
                        'todos_cinema_audiovisual:id,descricao',
                        'todos_jornalismo:id,descricao',
                        'todos_publicidade_propaganda:id,descricao',
                        'todos_relacoes_publicas:id,descricao',
                        'todos_producao_editorial:id,descricao',
                        'todos_radio_internet:id,descricao',
                        'associado',
                        'associado.instituicao:id,sigla_instituicao'
                    )
                    ->whereHas('avaliador_expocom', function ($query) {
                        return $query->where('avaliador_junior', '=', 1);
                    })
                    ->orderBy('name')->get();
    }

    public function getAvaliadoresExpocom(User $user)
    {
        return $user->select('id', 'name')
                    ->with(
                        'avaliador_expocom',
                        'todos_divisoes_tematicas:id,descricao',
                        'todos_divisoes_tematicas_jr:id,descricao',
                        'todos_cinema_audiovisual:id,descricao',
                        'todos_jornalismo:id,descricao',
                        'todos_publicidade_propaganda:id,descricao',
                        'todos_relacoes_publicas:id,descricao',
                        'todos_producao_editorial:id,descricao',
                        'todos_radio_internet:id,descricao',
                        'associado',
                        'associado.instituicao:id,sigla_instituicao'
                    )
                    ->whereHas('avaliador_expocom', function ($query) {
                        return $query->where('avaliador', '=', 1);
                    })
                    ->orderBy('name')->get();
    }

    public function getAvaliadoresNacional(User $user){
        return $user->select('id', 'name')
            ->with(
                'avaliador_expocom:id,user_id,nacional_gp,nacional_ij,nacional_publicom',
                'todos_divisoes_tematicas:id,descricao',
                'todos_divisoes_tematicas_jr:id,descricao',
                'todos_gps:id,descricao',
                )
            ->whereHas('avaliador_expocom', function ($query) {
                // $query->where('nacional_gp', 1);
                // $query->orWhere('nacional_ij', 1);
                // $query->orWhere('nacional_publicom', 1);
                $query->where(function($q){
                    $q->where('nacional_gp', 1)
                    ->orWhere('nacional_ij', 1)
                    ->orWhere('nacional_publicom', 1);
                });
            })
            ->orderBy('name')->get();
    }

    public function getCoordenador(Coordenador $coordenador, $id)
    {
        return $coordenador->select('id', 'user_id', 'tipo', 'regiao', 'dt')
            ->with('user:id,name')
            ->whereUserId($id)
            ->first();
    }

    public function getPagamentosStatuses(PagSeguroTipoStatus $pagSeguroTipoStatus)
    {
        return $pagSeguroTipoStatus->select('id', 'nome')->get();
    }
}
