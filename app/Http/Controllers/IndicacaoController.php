<?php

namespace App\Http\Controllers;

use App\Models\EnderecoIndicacao;
use App\Models\Indicacao;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndicacaoController extends Controller
{
    public function index()
    {
        return view('indicacao.form');
    }

    public function cpfCheckIndicacao(Request $request)
    {
        try {
            $usuario = Indicacao::select('id', 'cpf_autor')->where('cpf_autor', '=', $request->cpf)->withTrashed();

            if($usuario->first()) {
                if($usuario->first()->cpf_autor == $request->cpf) {
                    return response()->json(false);
                } else {
                    return response()->json(true);
                }
            } else {
                return response()->json(true);
            }
        } catch (Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            if($exception instanceof ModelNotFoundException){
                return abort(404, 'Registro não encontrado');
            }
            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }

    public function store(Request $request)
    {
        $post = $request->all();

        if( 
            $post['enderecos']['logradouro'] == null 
            && $post['enderecos']['numero'] == null 
            && $post['enderecos']['complemento'] == null 
            && $post['enderecos']['bairro'] == null 
            && $post['enderecos']['municipio'] == null 
            && $post['enderecos']['cep'] == null 
            && $post['enderecos']['pais'] == null
        ){

            $indicacao = Indicacao::create([
                "nome_respo" => $post['nome_respo'],
                "cpf_respo" => $post['cpf_respo'],
                "respo_indicacao" => $post['respo_indicacao'],
                "email_respo" => $post['email_respo'],
                "email_curso" => $post['email_curso'],
                "celular" => $post['celular'],
                "nome_autor" => $post['nome_autor'],
                "cpf_autor" => $post['cpf_autor'],
                "trabalho_produzido" => $post['trabalho_produzido'],
                "orientador" => $post['orientador'],
                "titulo_trabalho" => $post['titulo_trabalho'],
                "categoria" => $post['categoria'],
                "estado_id" => $post['estado_id'],
                "instituicao_id" => $post['instituicao_id'],
                "modalidade" => $post['modalidade'],
            ]);

        }else{

            $endereco = EnderecoIndicacao::create(
                [
                    'logradouro' => $post['enderecos']['logradouro'],
                    'numero' => $post['enderecos']['numero'],
                    'complemento' => $post['enderecos']['complemento'],
                    'bairro' => $post['enderecos']['bairro'],
                    'municipio_id' => $post['enderecos']['municipio']['id'] ?? null,
                    'cep' => $post['enderecos']['cep'],
                    'pais_id' => $post['enderecos']['pais'],
                    'updated_at' => Carbon::now()
                ]
            );
                
            $indicacao = Indicacao::create([
                "nome_respo" => $post['nome_respo'],
                "cpf_respo" => $post['cpf_respo'],
                "respo_indicacao" => $post['respo_indicacao'],
                "email_respo" => $post['email_respo'],
                "email_curso" => $post['email_curso'],
                "celular" => $post['celular'],
                "nome_autor" => $post['nome_autor'],
                "cpf_autor" => $post['cpf_autor'],
                "trabalho_produzido" => $post['trabalho_produzido'],
                "orientador" => $post['orientador'],
                "titulo_trabalho" => $post['titulo_trabalho'],
                "categoria" => $post['categoria'],
                "estado_id" => $post['estado_id'],
                "instituicao_id" => $post['instituicao_id'],
                "modalidade" => $post['modalidade'],
                "endereco_id" => $endereco['id'],
            ]);
    
        }

        Log::info('Indicacao Expocom Criada: ' . json_encode($request->all()));

        return response()->json(['message' => 'success', 'response' => $indicacao], 201);
    }    
}
