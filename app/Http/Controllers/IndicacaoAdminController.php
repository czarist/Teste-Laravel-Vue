<?php

namespace App\Http\Controllers;

use App\Models\EnderecoIndicacao;
use App\Models\Indicacao;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IndicacaoAdminController extends Controller
{
    public function index()
    {
        return view('admin.indicacao_expocom.index');
    }

    public function get(Request $request)
    {
        return Indicacao::select('id', 'nome_autor', 'cpf_autor', 'categoria', 'modalidade', 'titulo_trabalho', 'trabalho_produzido')
            ->with(
                'user:id,name,cpf'
            )
            ->when($request->categoria, function ($query) use ($request) {
                $query->where('categoria', '=', $request->categoria);
            })
            ->when($request->modalidade, function ($query) use ($request) {
                $query->where('modalidade', '=', $request->modalidade);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->when($request->type == 'name', function ($query) use ($request) {
                        $query->where('nome_autor', 'like', '%'.$request->search.'%');
                    });
                    $query->when($request->type == 'cpf', function ($query) use ($request) {
                        $query->where('cpf_autor', 'like', '%'.$request->search.'%');
                    });
                    $query->when($request->type == 'titulo', function ($query) use ($request) {
                        $query->where('titulo_trabalho', 'like', '%'.$request->search.'%');
                    });
                });
            })
            ->orderBy('id', 'DESC')
        ->paginate(20);
    }

    public function cpfCheckIndicacao(Request $request)
    {
        try {
            $usuario = Indicacao::select('id', 'cpf_autor')->where('cpf_autor', '=', $request->cpf);

            if ($usuario->first()) {
                if ($usuario->first()->cpf_autor == $request->cpf) {
                    return response()->json(false);
                } else {
                    return response()->json(true);
                }
            } else {
                return response()->json(true);
            }
        } catch (Exception $exception) {
            $exception_message = ! empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message.' in file '.$exception->getFile().' on line '.$exception->getLine());
            if ($exception instanceof ModelNotFoundException) {
                return abort(404, 'Registro não encontrado');
            }

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $post = $request->all();
            $indicacao = Indicacao::findOrFail($post['id']);
            $endereco = EnderecoIndicacao::find($indicacao->endereco_id);

            $indicacao->update([
                'nome_respo' => $post['nome_respo'],
                'cpf_respo' => $post['cpf_respo'],
                'respo_indicacao' => $post['respo_indicacao'],
                'email_respo' => $post['email_respo'],
                'email_curso' => $post['email_curso'],
                'celular' => $post['celular'],
                'nome_autor' => $post['nome_autor'],
                'cpf_autor' => $post['cpf_autor'],
                'trabalho_produzido' => $post['trabalho_produzido'],
                'orientador' => $post['orientador'],
                'titulo_trabalho' => $post['titulo_trabalho'],
                'categoria' => $post['categoria'],
                'estado_id' => $post['estado_id'],
                'instituicao_id' => $post['instituicao_id'],
                'modalidade' => $post['modalidade'],
            ]);

            if (! empty($endereco)) {
                $endereco->update([
                    'logradouro' => $post['enderecos']['logradouro'],
                    'numero' => $post['enderecos']['numero'],
                    'complemento' => $post['enderecos']['complemento'],
                    'bairro' => $post['enderecos']['bairro'],
                    'municipio_id' => $post['enderecos']['municipio']['id'],
                    'cep' => $post['enderecos']['cep'],
                    'pais_id' => $post['enderecos']['pais_id'] ?? 'Brasil',
                ]);
            }

            if (empty($endereco)) {
                $endereco_novo = EnderecoIndicacao::create([
                    'logradouro' => $post['enderecos']['logradouro'],
                    'numero' => $post['enderecos']['numero'],
                    'complemento' => $post['enderecos']['complemento'],
                    'bairro' => $post['enderecos']['bairro'],
                    'municipio_id' => $post['enderecos']['municipio']['id'],
                    'cep' => $post['enderecos']['cep'],
                    'pais_id' => $post['enderecos']['pais_id'] ?? 'Brasil',
                ]);

                $indicacao->update([
                    'endereco_id' => $endereco_novo['id'],
                ]);
            }

            Log::info('Indicacao Expocom Atualizada: '.json_encode($request->all()));

            return response()->json(['message' => 'success', 'response' => $indicacao], 201);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar Indicacao Expocom: '.$e->getMessage());

            return response()->json(['message' => 'error', 'response' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        if ($id) {
            $indicacao = Indicacao::findOrFail($id);

            if (! empty($indicacao)) {
                $indicacao->delete();
                Log::info('User ID: '.Auth::user()->id.' | DELETOU INDICAO: '.$id);

                return ['status' => 'true'];
            }
        }
    }
}
