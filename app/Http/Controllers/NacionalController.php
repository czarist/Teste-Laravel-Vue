<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\Endereco;
use App\Models\Nacional;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NacionalController extends Controller
{
    public function usuario(){
        return User::select('id', 'name', 'email', 'estrangeiro','passaporte','cpf','telefone','celular', 'rg', 'orgao_expedidor', 'data_nascimento', 'sexo_id')
            ->with('acessos:id,pagina,link',
                'todos_tipos:id,descricao',
                'todos_divisoes_tematicas:id,descricao',
                'todos_divisoes_tematicas_jr:id,descricao',
                'todos_cinema_audiovisual:id,descricao',
                'todos_jornalismo:id,descricao',
                'todos_publicidade_propaganda:id,descricao',
                'todos_relacoes_publicas:id,descricao',
                'todos_producao_editorial:id,descricao',
                'todos_radio_internet:id,descricao',
                'todos_gps:id,descricao',
                'enderecos',
                'enderecos.municipio',
                'enderecos.municipio.estado',
                'associado',
                'nacional'
                )
                ->find(Auth::user()->id);
    }

    public function index(){
        $user = $this->usuario();

        return view('nacional.inscricao.index', compact('user'));
    }

    // public function submissaoGp(){
    //     $user = $this->usuario();
    //     $tipo = 1;

    //     return view('nacional.inscricao.submissaogp', compact('user', 'tipo'));
    // }

    // public function submissaoJunior(){
    //     $user = $this->usuario();
    //     $tipo = 2;

    //     return view('nacional.inscricao.submissaojunior', compact('user', 'tipo'));
    // }

    // public function submissaoPublicom(){
    //     $user = $this->usuario();
    //     $tipo = 3;

    //     return view('nacional.inscricao.submissaopublicom', compact('user', 'tipo'));
    // }

    public function store(Request $request){
        try { 

            $post = $request->all();
            $post['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $post['data_nascimento'])->format('Y-m-d');
            unset($post['password']);
            $user = User::findOrFail($post['id']);

            if(!empty($user))
            {
                if($user->rg == $post['rg']) {
                    $user->update([
                        'name' => $post['name'],
                        'telefone' => $post['telefone'],
                        'celular' => $post['celular'],
                        'data_nascimento' => $post['data_nascimento'],
                        'sexo_id' => $post['sexo_id'],
                        'updated_at' => Carbon::now()
                    ]);
                }else{

                    $user->update([
                        'name' => $post['name'],
                        'telefone' => $post['telefone'],
                        'celular' => $post['celular'],
                        'data_nascimento' => $post['data_nascimento'],
                        'rg' => $post['rg'],
                        'orgao_expedidor' => $post['orgao_expedidor'],
                        'sexo_id' => $post['sexo_id'],
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            $associado = Associado::whereUserId($user->id)->first();   
            
            if(empty($associado))
            {
                $associado = Associado::create(
                    [
                        'user_id' => $user->id,
                        'instituicao_id' => $post['instituicao_id'],
                        'titulacao_id' => $post['titulacao_id'],
                    ]
                );

            }else{
                $associado->update(
                    [
                        'user_id' => $user->id,
                        'instituicao_id' => $post['instituicao_id'],
                        'titulacao_id' => $post['titulacao_id'],
                    ]
                );    
            }

            $endereco = Endereco::whereUserId($user->id)->first();   

            if(empty($endereco))
            {
                $endereco = Endereco::create(
                    [
                        'user_id' => $user->id,
                        'logradouro' => $post['endereco']['logradouro'],
                        'numero' => $post['endereco']['numero'],
                        'complemento' => $post['endereco']['complemento'],
                        'bairro' => $post['endereco']['bairro'],
                        'municipio_id' => $post['endereco']['municipio']['id'],
                        'cep' => $post['endereco']['cep'],
                        'pais_id' =>  $post['endereco']['pais'],
                        'updated_at' => Carbon::now()
                    ]
                );
        
            }else {
                $endereco->update(
                    [
                        'logradouro' => $post['endereco']['logradouro'],
                        'numero' => $post['endereco']['numero'],
                        'complemento' => $post['endereco']['complemento'],
                        'bairro' => $post['endereco']['bairro'],
                        'municipio_id' => $post['endereco']['municipio']['id'],
                        'cep' => $post['endereco']['cep'],
                        'pais_id' =>  $post['endereco']['pais'],
                        'updated_at' => Carbon::now()
                    ]
                );
            }

            $regional = Nacional::whereUserId($user->id)->first();   

            if(empty($regional))
            {
                Nacional::create([
                    'user_id' => $user->id,
                    'categoria_inscricao' => $post['titulacao_id'],
                    'ano' => date('Y'),
                    'guardador_sabado' => $post['guard_sab'],
                    'port_nece_espe' => $post['port_nece'],
                    'port_nece_espe_qual' => $post['qual'] ?? null ,
                    'port_nece_espe_outra' => $post['outra_necessidade'] ?? null ,
                    'updated_at' => Carbon::now()
                ]);
            }else{
                $regional->update([
                    'categoria_inscricao' => $post['titulacao_id'],
                    'ano' => date('Y'),
                    'guardador_sabado' => $post['guard_sab'],
                    'port_nece_espe' => $post['port_nece'],
                    'port_nece_espe_qual' => $post['qual'] ?? null ,
                    'port_nece_espe_outra' => $post['outra_necessidade'] ?? null ,
                    'updated_at' => Carbon::now()
                ]);
            }
            Log::info('User: '. Auth::user()->id . ' | Se inscreveu ou atualizou a inscrição no nacional: ' . json_encode($post));

            //Enviar e-mail informando que se inscreveu no nacional
            try {

                $dados_inscricao['post'] = $post;

                Mail::send('email.inscricao_regional', $dados_inscricao, function ($email) use ($dados_inscricao) {
                    if (App::environment('production')) {
                        $email->to($dados_inscricao['post']['email']);
                    } else {
                        $email->to($dados_inscricao['post']['email']);
                    }
                        $email->subject('Inscrição Nacional | Intercom');
                    Log::info('E-mail Enviado para o usuario informando que se inscreveu no nacional' . json_encode($dados_inscricao));
                });
            } catch (Exception $e) {
                Log::error('Não foi possível enviar e-mail para o usuario ERRO: ' . $e->getMessage() .  '  |  Linha: ' . $e->getLine() . ' | Arquivo: ' . $e->getFile());
            }
    
            return response()->json(['message' => 'success', 'response' => $user], 201);

        } catch (Exception $exception) {
            
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}
