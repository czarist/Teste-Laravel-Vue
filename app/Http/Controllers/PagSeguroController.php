<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\Endereco;
use App\Models\PagSeguroPgto;
use App\Models\Produto;
use App\Models\User;
use App\Models\Venda;
use App\Models\VendaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PagSeguroController extends Controller
{
    public function pagamento()
    {
        $url = env('URL_PAGSEGURO') . "sessions?email=" . env('EMAIL_PAGSEGURO') . "&token=" . env('TOKEN_PAGSEGURO');

	
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $retorno = curl_exec($curl);
        curl_close($curl);
        
        $xml = simplexml_load_string($retorno);
        echo json_encode($xml);
    
    }

    public function associadocredito(Request $request)
    { 

        $user = User::find($request->id);
        $user->update([
            'sexo_id' => $request->sexo_id ?? null,
            'telefone' => $request->telefone ?? null,
            'celular' => $request->celular ?? null,
            'data_nascimento' => $request->data_nascimento ?? null,                
        ]);

        if(Auth::user()->is_associado){
            $associado = Associado::whereUserId($user->id)->first();   
        }
        
        Associado::updateOrCreate(
            ['id' => $associado->id ?? null],
            [
                'instituicao_id' => $request->instituicao_id,
                'titulacao_id' => $request->titulacao_id,
            ]
        );

        if($user){
            $endereco = Endereco::whereUserId($user->id)->first();   
        }
        
        $endereco = Endereco::updateOrCreate(
            ['id' => $endereco->id ?? null],
            [
                'user_id' => $user->id,
                'logradouro' => $request->logradouro,
                'municipio_id' => $request->municipioId ?? 1,
                'cep' => $request->cep ?? 00000-000,
                'pais_id' => $request->pais ?? 'Brasil',
            ]
        );
        Log::info('Cadastro de usuario: ' . json_encode($user));

        if(!empty($request->associado) && $request->associado == 1){
            $produto = Produto::findOrFail(1);
        }

        if(!empty($request->anuidade2022) && $request->anuidade2022 == 1){
            $produto = Produto::findOrFail(2);
        }


        $venda = Venda::create(['user_id' => $user['id']]);
        Log::info('Venda efetuada  com sucesso'. json_encode($venda));

        $venda_item = VendaItem::create([
            'venda_id' => $venda->id, 
            'produto_id' => $produto->id, 
            'qtd' => $request->quantidade ?? 1, 
            'valor' => $produto->valor, 
            'valor_total' => $produto->valor * $request->quantidade
        ]);
        Log::info('Venda de  item efetuado com sucesso'. json_encode($venda_item));

        //Formatação de dados para o PagSeguro
        $cpf = str_replace(['.', '-'], '', $user->cpf);
        $cep = str_replace('.', '-', $request->cep);
        $celular_str = str_replace(['(', ')',' ','-'], '', $request->celular);

        $ddd = substr($celular_str, 0, 2);
        $celular = substr($celular_str, 2, 9);

        $email_pagseguro = env('EMAIL_PAGSEGURO');
        $token_pagseguro = env('TOKEN_PAGSEGURO');
        $url_notificacao = env('URL_NOTIFICACAO');

        $dados_pagseguro = [

            'email' => $email_pagseguro,
            'token' => $token_pagseguro,
            'receiverEmail' => $email_pagseguro,
            'notificationURL' => $url_notificacao,
            'billingAddressCountry' => 'Brasil',
            "paymentMode" => "default",
            "paymentMethod" => "creditCard",
            //fazer chamada para o metodo de pagamento
            "creditCardToken" => $request->tokenCartao, //token do cartao
            'senderHash' => $request->hashCartao, //hash gerado pelo pagseguro
            'installmentQuantity' => $request->parcelas, //quantidade de parcelas
            'installmentValue' => strval($request->valorParcela), //valor da parcela
            'extraAmount' => number_format(0, 2, '.', ''),    
            'creditCardHolderName' => $user->name ,
            'creditCardHolderCPF' => $cpf,
            'creditCardHolderBirthDate' => $user->data_nascimento ?? '01/01/2000',
            'creditCardHolderAreaCode' => $ddd,
            'creditCardHolderPhone' => $celular,
            'billingAddressStreet' => $request->logradouro,
            'billingAddressNumber' => "0",
            'billingAddressComplement' => "",
            'billingAddressDistrict' => $request->bairro ?? 'Centro',
            'billingAddressPostalCode' => $cep,
            'billingAddressCity' => $endereco['municipio']['nome'] ?? 'São Paulo',
            'billingAddressState' => $endereco['estado']['sigla'] ?? 'SP',
            'shippingAddressRequired' => False,
            'currency' => 'BRL',
            'itemId1' => $venda_item->id,
            'itemDescription1' => $produto->nome,
            'itemAmount1' => number_format($produto->valor, 2, '.', ''),
            'itemQuantity1' => 1,
            'reference' => $venda->id,
            'senderName' => $user->name,
            'senderCPF' => $cpf,
            'senderAreaCode' => $ddd,
            'senderPhone' => $celular,
            'senderEmail' => $user->email,
        ];

        $buildQuery = http_build_query($dados_pagseguro);
        $url = env('URL_PAGSEGURO') . "transactions";
    
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
        $retornoxml = curl_exec($curl);
        curl_close($curl);      
        $response = simplexml_load_string($retornoxml);

        Log::info('Pagamento efetuado'. json_encode($response));

        $codigo_venda = intval($response->reference);
        $codigo_tipo_pagto = intval($response->paymentMethod->type);
        $codigo_tipo_pagto_detalhe = $response->paymentMethod->code;
        $transacao = $response->code;
        $valor_venda = floatval($produto->valor);
        $parcelas = intval($request->parcelas);
        $valor_parcela = floatval($request->valorParcela);
        $valor_total = floatval($parcelas * $valor_parcela);
        $valor_juros = floatval($valor_total - $valor_venda);
        $valor_receber = floatval($response->netAmount);
        $codigo_status = intval($response->status);

        if(!$response->error){
     
            $pagamento = PagSeguroPgto::create([
                'tipo_pgto_detalhe' => $codigo_tipo_pagto_detalhe,
                'transacao' => $transacao,
                'parcelas' => $parcelas,
                'valor_parcela' => $valor_parcela,
                'valor_total' => $valor_total,
                'valor_juros' => $valor_juros,
                'valor_receber' => $valor_receber,
                'venda_id' => $codigo_venda,
                'tipo_pagto_id' => $codigo_tipo_pagto,
                'status_id' => $codigo_status,
                'user_id' => $user['id'],
            ]);
            
            $todos_tipos = [0 => 3 , 1 => 4];
            $user->todos_tipos()->sync($todos_tipos);
            
            Log::info('Pagamento efetuado com sucesso'. json_encode($pagamento));
            
            return response()->json(['message' => 'success', 'response' => $user], 201);
        }

        Log::info('Erro ao efetuar pagamento'. json_encode($response));
        return response()->json(['message' => 'error', 'response' => $response], 201);

    }

    public function associadocreditoanuidade(Request $request)
    { 
        $user = User::select('id', 'name', 'email','ativo', 'sexo_id', 'estrangeiro','passaporte','cpf','rg','orgao_expedidor','telefone','celular','data_nascimento')
            ->with('acessos:id,pagina,link',
                    'todos_tipos:id,descricao',
                    'enderecos',
                    'enderecos.municipio',
                    'enderecos.municipio.estado')
            ->whereId(Auth::user()->id)->first();

        if(!empty($request->anuidade2022) && $request->anuidade2022 == 1){
            $produto = Produto::findOrFail(2);
        }

        $venda = Venda::create(['user_id' => $user['id']]);
        Log::info('Venda efetuada  com sucesso'. json_encode($venda));

        $venda_item = VendaItem::create([
            'venda_id' => $venda->id, 
            'produto_id' => $produto->id, 
            'qtd' => $request->quantidade ?? 1, 
            'valor' => $produto->valor, 
            'valor_total' => $produto->valor * $request->quantidade
        ]);
        Log::info('Venda de  item efetuado com sucesso'. json_encode($venda_item));

        //Formatação de dados para o PagSeguro
        $cpf = str_replace(['.', '-'], '', $user->cpf);
        $cep = str_replace('.', '-', $user->enderecos[0]->cep);
        $celular_str = str_replace(['(', ')',' ','-'], '', $user->celular);

        $ddd = substr($celular_str, 0, 2);
        $celular = substr($celular_str, 2, 9);

        $email_pagseguro = env('EMAIL_PAGSEGURO');
        $token_pagseguro = env('TOKEN_PAGSEGURO');
        $url_notificacao = env('URL_NOTIFICACAO');

        $dados_pagseguro = [

            'email' => $email_pagseguro,
            'token' => $token_pagseguro,
            'receiverEmail' => $email_pagseguro,
            'notificationURL' => $url_notificacao,
            'billingAddressCountry' => 'Brasil',
            "paymentMode" => "default",
            "paymentMethod" => "creditCard",
            //fazer chamada para o metodo de pagamento
            "creditCardToken" => $request->tokenCartao, //token do cartao
            'senderHash' => $request->hashCartao, //hash gerado pelo pagseguro
            'installmentQuantity' => $request->parcelas, //quantidade de parcelas
            'installmentValue' => strval($request->valorParcela), //valor da parcela
            'extraAmount' => number_format(0, 2, '.', ''),    
            'creditCardHolderName' => $user->name ,
            'creditCardHolderCPF' => $cpf,
            'creditCardHolderBirthDate' => $user->data_nascimento ?? '01/01/2000',
            'creditCardHolderAreaCode' => $ddd,
            'creditCardHolderPhone' => $celular,
            'billingAddressStreet' => $user->enderecos[0]->logradouro,
            'billingAddressNumber' => "0",
            'billingAddressComplement' => "",
            'billingAddressDistrict' => $user->enderecos[0]->bairro ?? 'Centro',
            'billingAddressPostalCode' => $cep,
            'billingAddressCity' => $user->enderecos[0]['municipio']['nome'] ?? 'São Paulo',
            'billingAddressState' => $user->enderecos[0]['estado']['sigla'] ?? 'SP',
            'shippingAddressRequired' => False,
            'currency' => 'BRL',
            'itemId1' => $venda_item->id,
            'itemDescription1' => $produto->nome,
            'itemAmount1' => number_format($produto->valor, 2, '.', ''),
            'itemQuantity1' => 1,
            'reference' => $venda->id,
            'senderName' => $user->name,
            'senderCPF' => $cpf,
            'senderAreaCode' => $ddd,
            'senderPhone' => $celular,
            'senderEmail' => $user->email,
        ];

        Log::info('Dados para pagamento enviados ao PagSeguro'. json_encode($dados_pagseguro));

        $buildQuery = http_build_query($dados_pagseguro);
        $url = env('URL_PAGSEGURO') . "transactions";
    
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
        $retornoxml = curl_exec($curl);
        curl_close($curl);      
        $response = simplexml_load_string($retornoxml);

        Log::info('Pagamento efetuado'. json_encode($response));

        $codigo_venda = intval($response->reference);
        $codigo_tipo_pagto = intval($response->paymentMethod->type);
        $codigo_tipo_pagto_detalhe = $response->paymentMethod->code;
        $transacao = $response->code;
        $valor_venda = floatval($produto->valor);
        $parcelas = intval($request->parcelas);
        $valor_parcela = floatval($request->valorParcela);
        $valor_total = floatval($parcelas * $valor_parcela);
        $valor_juros = floatval($valor_total - $valor_venda);
        $valor_receber = floatval($response->netAmount);
        $codigo_status = intval($response->status);

        if(!$response->error){
     
            $pagamento = PagSeguroPgto::create([
                'tipo_pgto_detalhe' => $codigo_tipo_pagto_detalhe,
                'transacao' => $transacao,
                'parcelas' => $parcelas,
                'valor_parcela' => $valor_parcela,
                'valor_total' => $valor_total,
                'valor_juros' => $valor_juros,
                'valor_receber' => $valor_receber,
                'venda_id' => $codigo_venda,
                'tipo_pagto_id' => $codigo_tipo_pagto,
                'status_id' => $codigo_status,
                'user_id' => $user['id'],
            ]);
            
            $todos_tipos = [0 => 3 , 1 => 4];
            $user->todos_tipos()->sync($todos_tipos);
            
            Log::info('Pagamento efetuado com sucesso'. json_encode($pagamento));
            
            return response()->json(['message' => 'success', 'response' => $user], 201);
        }

        Log::info('Erro ao efetuar pagamento'. json_encode($response));
        return response()->json(['message' => 'error', 'response' => $response], 201);

    }


    public function retorno(){
        header(env('RETORNO_HEADER'));
	
        if (!isset($_POST['notificationCode']) || $_POST['notificationType'] != 'transaction') {

            Log::info('Erro ao receber retorno do pagseguro');
            $msg = "Erro ao receber retorno do pagseguro";
            exit;
        }
    
        $notificationCode = preg_replace('/[^[:alnum:]-]/','',$_POST["notificationCode"]);	
        $url = env('RETORNO_PAGSEGURO').$notificationCode.'?email='.env('EMAIL_PAGSEGURO').'&token='.env('TOKEN_PAGSEGURO');	
        
        $curl = curl_init($url);	
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);	
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);	
        $xml= curl_exec($curl);	
        curl_close($curl);
    
        if($xml == 'Unauthorized'){

            Log::info('Erro ao tentar consultar o pagseguro');

            $msg = 'Retorno do xml Unauthorized';
            exit;	
        }
    
        $xml = simplexml_load_string($xml);
        $transaction = $xml->code;
        $codigovenda = $xml->reference;
        $codigostatus = $xml->status;
        $xml->paymentMethod->code;
        
        if ($codigovenda && $codigostatus) {		
            
            $pagamento = PagSeguroPgto::select('id')->whereVendaId($codigovenda)->whereTransacao($transaction)->whereStatusId($codigostatus)->first();

            if(empty($pagamento)){

                $pagamento = PagSeguroPgto::select('id')->whereVendaId($codigovenda)->whereTransacao($transaction)->first();
                $pagamento->update([
                    'status_id' => $codigostatus,
                ]);
        
                Log::info('Pagamento atualizado com sucesso'. json_encode($pagamento));

            }else{
                Log::info('Pagamento já atualizado'. json_encode($pagamento));
            }
        } else {
            Log::info('Erro ao atualizar pagamento'. json_encode($xml));
        }  
        return response()->json(['message' => 'success', 'response' => $xml], 201);
    }
}

