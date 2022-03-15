<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\Endereco;
use App\Models\RegionalNordeste;
use App\Models\User;
use App\Models\Venda;
use App\Models\VendaItem;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegionalNordesteController extends Controller
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
                'enderecos',
                'enderecos.municipio',
                'enderecos.municipio.estado',
                'associado',
                'avaliador_expocom',
                'regional_nordeste'
                )
                ->find(Auth::user()->id);
    }

    public function formregionalnordeste(){
        $user = $this->usuario();
        $regiao = 2;

        return view('regionais.nordeste.form', compact('user', 'regiao'));
    }

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
                    ]
                );

            }else{
                $associado->update(
                    [
                        'user_id' => $user->id,
                        'instituicao_id' => $post['instituicao_id'],
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
                        'pais_id' => $post['pais'],
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
                        'pais_id' => $post['pais'],
                        'updated_at' => Carbon::now()
                    ]
                );
            }

            $regional = RegionalNordeste::whereUserId($user->id)->first();   

            if(empty($regional))
            {
                RegionalNordeste::create([
                    'user_id' => $user->id,
                    'regiao' => 'nordeste',
                    'categoria_inscricao' => $post['titulacao_id'],
                    'numero_matricula' => $post['numero_matricula'],
                    'ano' => date('Y'),
                    'guardador_sabado' => $post['guard_sab'],
                    'port_nece_espe' => $post['port_nece'],
                    'port_nece_espe_qual' => $post['outra_necessidade'] ?? null ,
                    'updated_at' => Carbon::now()
                ]);
            }else{
                $regional->update([
                    'regiao' => 'nordeste',
                    'categoria_inscricao' => $post['titulacao_id'],
                    'numero_matricula' => $post['numero_matricula'],
                    'ano' => date('Y'),
                    'guardador_sabado' => $post['guard_sab'],
                    'port_nece_espe' => $post['port_nece'],
                    'port_nece_espe_qual' => $post['qual'] ?? null ,
                    'port_nece_espe_outra' => $post['outra_necessidade'] ?? null ,
                    'updated_at' => Carbon::now()
                ]);
            }

            if(Auth::user()->anuidade_2022 && Auth::user()->is_associado){
        
                if(Auth::user()->pago_regional_nordeste_2022 == false){

                    $todos_tipos = [0 => 7];
                    $user->todos_tipos()->attach($todos_tipos);
                
                    Log::info('Usuário '.$user->id.' liberado inscrição regional nordeste '.date('Y').'');
                }
            }

            Log::info('User: '. Auth::user()->id . ' | Atualizou Usuario: ' . json_encode($post));
    
            return response()->json(['message' => 'success', 'response' => $user], 201);

        } catch (Exception $exception) {
            
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';

            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());

            return response()->json(['message' => config('app.debug') ? $exception_message : 'Server Error'], 500);
        }
    }
}
