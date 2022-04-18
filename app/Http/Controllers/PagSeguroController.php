<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\Endereco;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\PagSeguroPgto;
use App\Models\Produto;
use App\Models\ProdutosRegionais;
use App\Models\User;
use App\Models\Venda;
use App\Models\VendaItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
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
                    'instituicao_id' => $request->instituicao_id,
                    'titulacao_id' => $request->titulacao_id,
                ]
            );

        }else
        {
            $associado->update(
                [
                    'user_id' => $user->id,
                    'instituicao_id' => $request->instituicao_id,
                    'titulacao_id' => $request->titulacao_id,
                ]
            );    
        }

        $endereco = Endereco::whereUserId($user->id)->first();   

        if(empty($endereco))
        {
            $endereco = Endereco::create(
                [
                    'user_id' => $user->id,
                    'logradouro' => $request->logradouro ?? 'Rua Vitorino Carmilo',
                    'numero' => $request->numero ?? '0',
                    'complemento' => $request->complemento ?? '',
                    'bairro' => $request->bairro ?? 'Centro',
                    'municipio_id' => $request->municipio ?? 1,
                    'cep' => $request->cep ?? '01153000',
                    'pais_id' => $request->pais ?? 'Brasil',
                    'updated_at' => Carbon::now()
                ]
            );
    
        }else {
            $endereco->update(
                [
                    'user_id' => $user->id,
                    'logradouro' => $request->logradouro ?? 'Rua Vitorino Carmilo',
                    'numero' => $request->numero ?? '0',
                    'complemento' => $request->complemento ?? '',
                    'bairro' => $request->bairro ?? 'Centro',
                    'municipio_id' => $request->municipio ?? 1,
                    'cep' => $request->cep ?? '01153000',
                    'pais_id' => $request->pais ?? 'Brasil',
                    'updated_at' => Carbon::now()
                ]
            );
        }

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
            'qtd' => $request->parcelas ?? 1, 
            'valor' => $produto->valor, 
            'valor_total' => $produto->valor * $request->parcelas ?? 1
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
            'creditCardHolderBirthDate' => '01/01/2000',
            // 'creditCardHolderBirthDate' => $user->data_nascimento ?? '01/01/2000',
            'creditCardHolderAreaCode' => $ddd,
            'creditCardHolderPhone' => $celular,
            'billingAddressStreet' => $request->logradouro ?? 'Rua Vitorino Carmilo',
            'billingAddressNumber' => "0",
            'billingAddressComplement' => "",
            'billingAddressDistrict' => $request->bairro ?? 'Centro',
            'billingAddressPostalCode' => $cep ?? '01153000',
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
            
            Log::info('Pagamento efetuado com sucesso'. json_encode($pagamento));
            
            return response()->json(['message' => 'success', 'response' => $pagamento], 201);
        }

        Log::info('Erro ao efetuar pagamento'. json_encode($response));
        return response()->json(['message' => 'error', 'response' => $response], 201);

    }

    public function associadoboleto(Request $request)
    {
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
                    'instituicao_id' => $request->instituicao_id,
                    'titulacao_id' => $request->titulacao_id,
                ]
            );
    
        }else
        {
            $associado->update(
                [
                    'user_id' => $user->id,
                    'instituicao_id' => $request->instituicao_id,
                    'titulacao_id' => $request->titulacao_id,
                ]
            );    
        }
    
        $endereco = Endereco::whereUserId($user->id)->first();   
    
        if(empty($endereco))
        {
            $endereco = Endereco::create(
                [
                    'user_id' => $user->id,
                    'logradouro' => $request->logradouro ?? 'Rua Vitorino Carmilo',
                    'numero' => $request->numero ?? '0',
                    'complemento' => $request->complemento ?? '',
                    'bairro' => $request->bairro ?? 'Centro',
                    'municipio_id' => $request->municipio ?? 1,
                    'cep' => $request->cep ?? '01153000',
                    'pais_id' => $request->pais ?? 'Brasil',
                    'updated_at' => Carbon::now()
                ]
            );
    
        }else {
            $endereco->update(
                [
                    'user_id' => $user->id,
                    'logradouro' => $request->logradouro ?? 'Rua Vitorino Carmilo',
                    'numero' => $request->numero ?? '0',
                    'complemento' => $request->complemento ?? '',
                    'bairro' => $request->bairro ?? 'Centro',
                    'municipio_id' => $request->municipio ?? 1,
                    'cep' => $request->cep ?? '01153000',
                    'pais_id' => $request->pais ?? 'Brasil',
                    'updated_at' => Carbon::now()
                ]
            );
        }
    
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
            'qtd' => $request->parcelas ?? 1, 
            'valor' => $produto->valor, 
            'valor_total' => $produto->valor
        ]);
        Log::info('Venda de  item efetuado com sucesso'. json_encode($venda_item));

        //Formatação de dados para o PagSeguro
        $cpf = str_replace(['.', '-'], '', $user->cpf);
        $cep = str_replace('.', '-', $endereco->cep);
        $celular_str = str_replace(['(', ')',' ','-'], '', $request->celular);

        $ddd = substr($celular_str, 0, 2);
        $celular = substr($celular_str, 2, 9);

        $email_pagseguro = env('EMAIL_PAGSEGURO');
        $token_pagseguro = env('TOKEN_PAGSEGURO');
        $url_notificacao = env('URL_NOTIFICACAO');
        $email_loja = env('EMAIL_LOJA');
        $moeda_pagamento = env('MOEDA_PAGAMENTO');
        $billingAddressCountry = env('BILLINGADDRESSCOUNTRY');

        
        $dados_pagseguro = [
            
            'email' => $email_pagseguro,
            'token' => $token_pagseguro,
            'receiverEmail' => $email_loja,
            'notificationURL' => $url_notificacao,
            'billingAddressCountry' => $billingAddressCountry,
            "paymentMode" => "default",
            "paymentMethod" => "boleto",
            
            'senderHash' => $request->hashBoleto, //hash gerado pelo pagseguro
            'installmentValue' => strval($request->valorParcela), //valor da parcela
            'extraAmount' => number_format(0, 2, '.', ''),  
            
            'shippingAddressRequired' => False,
            'currency' => $moeda_pagamento,
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
                        
            Log::info('Pagamento efetuado com sucesso'. json_encode($pagamento));
            
            return response()->json(['message' => 'success', 'response' => $response], 201);
        }

        Log::info('Erro ao efetuar pagamento'. json_encode($response));
        return response()->json(['message' => 'error', 'response' => $response], 201);
        
    }
    
    public function associadocreditoanuidade(Request $request)
    { 

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

        $endereco = Endereco::whereUserId($user->id)->first();   
    
        if(empty($endereco))
        {
            $endereco = Endereco::create(
                [
                    'user_id' => $user->id,
                    'logradouro' => $request->logradouro ?? 'Rua Vitorino Carmilo',
                    'numero' => $request->numero ?? '0',
                    'complemento' => $request->complemento ?? '',
                    'bairro' => $request->bairro ?? 'Centro',
                    'municipio_id' => $request->municipio ?? 1,
                    'cep' => $request->cep ?? '01153000',
                    'pais_id' => $request->pais ?? 'Brasil',
                    'updated_at' => Carbon::now()
                ]
            );
    
        }else {
            $endereco->update(
                [
                    'user_id' => $user->id,
                    'logradouro' => $request->logradouro ?? 'Rua Vitorino Carmilo',
                    'numero' => $request->numero ?? '0',
                    'complemento' => $request->complemento ?? '',
                    'bairro' => $request->bairro ?? 'Centro',
                    'municipio_id' => $request->municipio ?? 1,
                    'cep' => $request->cep ?? '01153000',
                    'pais_id' => $request->pais ?? 'Brasil',
                    'updated_at' => Carbon::now()
                ]
            );
        }
    
        Log::info('Pagamento anuidade credito | Dados do Usuario salvo: ' . json_encode($user));
    
    
        $associado = Associado::whereUserId($user->id)->first();   
        
        if(!empty($associado))
        {
            $date = Carbon::now();
            $date = date('Y', strtotime($date));

            $associado->update( ['anuidade' => $date ]);
        }

        Log::info('Pagamento anuidade credito | Associado atualizado : ' . json_encode($associado));
    
        if(!empty($request->anuidade2022) && $request->anuidade2022 == 1){
            $produto = Produto::findOrFail(2);
        }

        $venda = Venda::create(['user_id' => $user['id']]);
        Log::info('Pagamento anuidade credito | Venda efetuada  com sucesso'. json_encode($venda));

        $venda_item = VendaItem::create([
            'venda_id' => $venda->id, 
            'produto_id' => $produto->id, 
            'qtd' => $request->parcelas ?? 1, 
            'valor' => $produto->valor, 
            'valor_total' => $produto->valor
        ]);
        Log::info('Pagamento anuidade credito | Venda de  item efetuado com sucesso'. json_encode($venda_item));

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
            'creditCardHolderBirthDate' => '01/01/2000',
            // 'creditCardHolderBirthDate' => $user->data_nascimento ?? '01/01/2000',
            'creditCardHolderAreaCode' => $ddd,
            'creditCardHolderPhone' => $celular,
            'billingAddressStreet' => $user->enderecos[0]->logradouro ?? 'Rua Vitorino Carmilo',
            'billingAddressNumber' => $user->enderecos[0]->numero ?? "0",
            'billingAddressComplement' => "",
            'billingAddressDistrict' => $user->enderecos[0]->bairro ?? 'Centro',
            'billingAddressPostalCode' => $cep ?? '01153000',
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

        Log::info('Pagamento anuidade credito | Dados para pagamento enviados ao PagSeguro'. json_encode($dados_pagseguro));

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

        Log::info('Pagamento anuidade credito | Pagamento efetuado'. json_encode($response));

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
                        
            Log::info('Pagamento anuidade credito | Pagamento efetuado com sucesso'. json_encode($pagamento));
            
            return response()->json(['message' => 'success', 'response' => $user], 201);
        }

        Log::info('Pagamento anuidade credito | Erro ao efetuar pagamento'. json_encode($response));
        return response()->json(['message' => 'error', 'response' => $response], 201);

    }

    public function associadoboletoanuidade(Request $request)
    {
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

        $endereco = Endereco::whereUserId($user->id)->first();   
    
        if(empty($endereco))
        {
            $endereco = Endereco::create(
                [
                    'user_id' => $user->id,
                    'logradouro' => $request->logradouro ?? 'Rua Vitorino Carmilo',
                    'numero' => $request->numero ?? '0',
                    'complemento' => $request->complemento ?? '',
                    'bairro' => $request->bairro ?? 'Centro',
                    'municipio_id' => $request->municipio ?? 1,
                    'cep' => $request->cep ?? '01153000',
                    'pais_id' => $request->pais ?? 'Brasil',
                    'updated_at' => Carbon::now()
                ]
            );
    
        }else {
            $endereco->update(
                [
                    'user_id' => $user->id,
                    'logradouro' => $request->logradouro ?? 'Rua Vitorino Carmilo',
                    'numero' => $request->numero ?? '0',
                    'complemento' => $request->complemento ?? '',
                    'bairro' => $request->bairro ?? 'Centro',
                    'municipio_id' => $request->municipio ?? 1,
                    'cep' => $request->cep ?? '01153000',
                    'pais_id' => $request->pais ?? 'Brasil',
                    'updated_at' => Carbon::now()
                ]
            );
        }
    
        Log::info('Pagamento anuidade boleto | Dados do Usuario salvo: ' . json_encode($user));

        $associado = Associado::whereUserId($user->id)->first();   
        
        if(!empty($associado))
        {
            $date = Carbon::now();
            $date = date('Y', strtotime($date));

            $associado->update( ['anuidade' => $date ]);
        }

        Log::info('Pagamento anuidade boleto | Anuidade atualizada : ' . json_encode($associado));

        if(!empty($request->associado) && $request->associado == 1){
            $produto = Produto::findOrFail(1);
        }

        if(!empty($request->anuidade2022) && $request->anuidade2022 == 1){
            $produto = Produto::findOrFail(2);
        }

        $venda = Venda::create(['user_id' => $user['id']]);
        Log::info('Pagamento anuidade boleto | Venda efetuada  com sucesso'. json_encode($venda));

        $venda_item = VendaItem::create([
            'venda_id' => $venda->id, 
            'produto_id' => $produto->id, 
            'qtd' => $request->parcelas ?? 1, 
            'valor' => $produto->valor, 
            'valor_total' => $produto->valor
        ]);
        Log::info('Pagamento anuidade boleto | Venda de  item efetuado com sucesso'. json_encode($venda_item));

        //Formatação de dados para o PagSeguro
        $cpf = str_replace(['.', '-'], '', $user->cpf);
        $cep = str_replace('.', '-', $user->enderecos[0]->cep);
        $celular_str = str_replace(['(', ')',' ','-'], '', $user->celular);

        $ddd = substr($celular_str, 0, 2);
        $celular = substr($celular_str, 2, 9);

        $email_pagseguro = env('EMAIL_PAGSEGURO');
        $token_pagseguro = env('TOKEN_PAGSEGURO');
        $url_notificacao = env('URL_NOTIFICACAO');
        $email_loja = env('EMAIL_LOJA');
        $moeda_pagamento = env('MOEDA_PAGAMENTO');
        $billingAddressCountry = env('BILLINGADDRESSCOUNTRY');


        $dados_pagseguro = [

            'email' => $email_pagseguro,
            'token' => $token_pagseguro,
            'receiverEmail' => $email_loja,
            'notificationURL' => $url_notificacao,
            'billingAddressCountry' => $billingAddressCountry,
            "paymentMode" => "default",
            "paymentMethod" => "boleto",

            'senderHash' => $request->hashBoleto, //hash gerado pelo pagseguro
            'installmentValue' => strval($request->valorParcela), //valor da parcela
            'extraAmount' => number_format(0, 2, '.', ''),  

            'shippingAddressRequired' => False,
            'currency' => $moeda_pagamento,
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

        Log::info('Pagamento anuidade boleto | Pagamento efetuado'. json_encode($response));

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
            
            
            Log::info('Pagamento anuidade boleto | Pagamento efetuado com sucesso'. json_encode($pagamento));
            
            return response()->json(['message' => 'success', 'response' => $response], 201);
        }

        Log::info('Pagamento anuidade boleto | Erro ao efetuar pagamento'. json_encode($response));
        return response()->json(['message' => 'error', 'response' => $response], 201);

    }

    public function regionaiscredito(Request $request)
    { 

        $post = $request->all();
        unset($post['password']);
        unset($post['numCartao']);
        unset($post['cvv']);
        unset($post['validade']);
        
        $user = User::findOrFail($post['id']);

        $produto = Produto::findOrFail($post['produto']);
        $endereco = $user->enderecos()->first();
        $municipio = Municipio::findOrFail($endereco->municipio_id);
        $estado = Estado::findOrFail($municipio->estado_id);

        $venda = Venda::create(['user_id' => $user['id']]);
        Log::info('Pagamento Regional Sul '.date('Y').' | Venda efetuada  com sucesso'. json_encode($venda));

        $venda_item = VendaItem::create([
            'venda_id' => $venda->id, 
            'produto_id' => $produto->id, 
            'qtd' => $post['parcelas'] ?? 1, 
            'valor' => $produto->valor, 
            'valor_total' => $produto->valor
        ]);
        Log::info('Pagamento Regional Sul '.date('Y').' | Venda de  item efetuado com sucesso'. json_encode($venda_item));

        //Formatação de dados para o PagSeguro
        $cpf = str_replace(['.', '-'], '', $user->cpf);
        $cep = str_replace('.', '-', $endereco->cep);
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
            'creditCardHolderBirthDate' => '01/01/2000',
            // 'creditCardHolderBirthDate' => $user->data_nascimento ?? '01/01/2000',
            'creditCardHolderAreaCode' => $ddd,
            'creditCardHolderPhone' => $celular,
            'billingAddressStreet' => $endereco->logradouro ?? 'Rua Vitorino Carmilo',
            'billingAddressNumber' => $endereco->numero ?? "0",
            'billingAddressComplement' => "",
            'billingAddressDistrict' => $endereco->bairro ?? 'Centro',
            'billingAddressPostalCode' => $cep ?? '01153000',
            'billingAddressCity' => $municipio['nome'] ?? 'São Paulo',
            'billingAddressState' => $estado['sigla'] ?? 'SP',
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

        Log::info('Pagamento Regional Sul '.date('Y').'  | Dados para pagamento enviados ao PagSeguro'. json_encode($dados_pagseguro));

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

        Log::info('Pagamento Regional Sul '.date('Y').'  | Pagamento efetuado'. json_encode($response));

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
                        
            Log::info('Pagamento Regional Sul '.date('Y').'  | Pagamento efetuado com sucesso'. json_encode($pagamento));

            return response()->json(['message' => 'success', 'response' => $user], 201);
        }

        Log::info('Pagamento Regional Sul '.date('Y').'  | Erro ao efetuar pagamento'. json_encode($response));
        return response()->json(['message' => 'error', 'response' => $response], 201);

    }

    public function regionaisboleto(Request $request)
    {
        $post = $request->all();
        unset($post['password']);
        unset($post['password']);
        unset($post['numCartao']);
        unset($post['cvv']);
        unset($post['validade']);
    
        $user = User::findOrFail($post['id']);
        $produto = Produto::findOrFail($post['produto']['id']);
        $endereco = $user->enderecos()->first();
        $municipio = Municipio::findOrFail($endereco->municipio_id);
        $estado = Estado::findOrFail($municipio->estado_id);
    
        $venda = Venda::create(['user_id' => $user['id']]);
        Log::info('Pagamento anuidade boleto | Venda efetuada  com sucesso'. json_encode($venda));

        $venda_item = VendaItem::create([
            'venda_id' => $venda->id, 
            'produto_id' => $produto->id, 
            'qtd' => $post['parcelas'] ?? 1, 
            'valor' => $produto->valor, 
            'valor_total' => $produto->valor
        ]);
        Log::info('Pagamento Regional Sul '.date('Y').' | Venda de  item efetuado com sucesso'. json_encode($venda_item));

        //Formatação de dados para o PagSeguro
        $cpf = str_replace(['.', '-'], '', $user->cpf);
        $cep = str_replace('.', '-', $endereco->cep);
        $celular_str = str_replace(['(', ')',' ','-'], '', $user->celular);

        $ddd = substr($celular_str, 0, 2);
        $celular = substr($celular_str, 2, 9);

        $email_pagseguro = env('EMAIL_PAGSEGURO');
        $token_pagseguro = env('TOKEN_PAGSEGURO');
        $url_notificacao = env('URL_NOTIFICACAO');
        $email_loja = env('EMAIL_LOJA');
        $moeda_pagamento = env('MOEDA_PAGAMENTO');
        $billingAddressCountry = env('BILLINGADDRESSCOUNTRY');


        $dados_pagseguro = [

            'email' => $email_pagseguro,
            'token' => $token_pagseguro,
            'receiverEmail' => $email_loja,
            'notificationURL' => $url_notificacao,
            'billingAddressCountry' => $billingAddressCountry,
            "paymentMode" => "default",
            "paymentMethod" => "boleto",

            'senderHash' => $request->hashBoleto, //hash gerado pelo pagseguro
            'installmentValue' => strval($request->valorParcela), //valor da parcela
            'extraAmount' => number_format(0, 2, '.', ''),  

            'shippingAddressRequired' => False,
            'currency' => $moeda_pagamento,
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

        Log::info('Pagamento anuidade boleto | Pagamento efetuado'. json_encode($response));

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
            
            
            Log::info('Pagamento Regional Sul boleto | Pagamento efetuado com sucesso'. json_encode($pagamento));
            
            return response()->json(['message' => 'success', 'response' => $response], 201);
        }

        Log::info('Pagamento Regional Sul boleto | Erro ao efetuar pagamento'. json_encode($response));
        return response()->json(['message' => 'error', 'response' => $response], 201);

    }

    public function nacionalcredito(Request $request)
    { 

        $post = $request->all();
        unset($post['password']);
        unset($post['numCartao']);
        unset($post['cvv']);
        unset($post['validade']);
        
        $user = User::select('id', 'name', 'cpf', 'celular', 'email')
                    ->with('enderecos', 'enderecos.municipio', 'enderecos.municipio.estado')
                        ->find($post['id']);


        $produto = Produto::findOrFail($post['produto']);
        $endereco = $user->enderecos[0];
        $municipio = $user->enderecos[0]->municipio;
        $estado = $user->enderecos[0]->municipio->estado;

        $venda = Venda::create(['user_id' => $user['id']]);
        Log::info('Pagamento Nacional '.date('Y').' | Venda efetuada  com sucesso'. json_encode($venda));

        $venda_item = VendaItem::create([
            'venda_id' => $venda->id, 
            'produto_id' => $produto->id, 
            'qtd' => $post['parcelas'] ?? 1, 
            'valor' => $produto->valor, 
            'valor_total' => $produto->valor
        ]);
        Log::info('Pagamento Nacional '.date('Y').' | Venda de  item efetuado com sucesso'. json_encode($venda_item));

        //Formatação de dados para o PagSeguro
        $cpf = str_replace(['.', '-'], '', $user->cpf);
        $cep = str_replace('.', '-', $endereco->cep);
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
            'creditCardHolderBirthDate' => '01/01/2000',
            // 'creditCardHolderBirthDate' => $user->data_nascimento ?? '01/01/2000',
            'creditCardHolderAreaCode' => $ddd,
            'creditCardHolderPhone' => $celular,
            'billingAddressStreet' => $endereco->logradouro,
            'billingAddressNumber' => $endereco->numero,
            'billingAddressComplement' => "",
            'billingAddressDistrict' => $endereco->bairro,
            'billingAddressPostalCode' => $cep,
            'billingAddressCity' => $municipio['nome'],
            'billingAddressState' => $estado['sigla'],
            'shippingAddressRequired' => False,
            'currency' => 'BRL',
            'itemId1' => $venda_item->id,
            'itemDescription1' => $produto->categoria. ' - ' .$produto->nome,
            'itemAmount1' => number_format($produto->valor, 2, '.', ''),
            'itemQuantity1' => 1,
            'reference' => $venda->id,
            'senderName' => $user->name,
            'senderCPF' => $cpf,
            'senderAreaCode' => $ddd,
            'senderPhone' => $celular,
            'senderEmail' => $user->email,
        ];

        Log::info('Pagamento Nacional '.date('Y').'  | Dados para pagamento enviados ao PagSeguro'. json_encode($dados_pagseguro));

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

        Log::info('Pagamento Nacional '.date('Y').'  | Pagamento efetuado'. json_encode($response));

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
                        
            Log::info('Pagamento Nacional '.date('Y').'  | Pagamento efetuado com sucesso'. json_encode($pagamento));

            return response()->json(['message' => 'success', 'response' => $user], 201);
        }

        Log::info('Pagamento Nacional '.date('Y').'  | Erro ao efetuar pagamento'. json_encode($response));
        return response()->json(['message' => 'error', 'response' => $response], 201);

    }

    public function nacionalboleto(Request $request)
    {
        $post = $request->all();
        unset($post['password']);
        unset($post['numCartao']);
        unset($post['cvv']);
        unset($post['validade']);
    
        $user = User::select('id', 'name', 'cpf', 'celular', 'email')
                    ->with('enderecos', 'enderecos.municipio', 'enderecos.municipio.estado')
                        ->find($post['id']);


        $produto = Produto::findOrFail($post['produto']['id']);
        $endereco = $user->enderecos[0];
        $municipio = $user->enderecos[0]->municipio;
        $estado = $user->enderecos[0]->municipio->estado;
    
        $venda = Venda::create(['user_id' => $user['id']]);
        Log::info('Pagamento Nacional boleto | Venda efetuada  com sucesso'. json_encode($venda));

        $venda_item = VendaItem::create([
            'venda_id' => $venda->id, 
            'produto_id' => $produto->id, 
            'qtd' => $post['parcelas'] ?? 1, 
            'valor' => $produto->valor, 
            'valor_total' => $produto->valor
        ]);
        Log::info('Pagamento Nacional '.date('Y').' | Venda de  item efetuado com sucesso'. json_encode($venda_item));

        //Formatação de dados para o PagSeguro
        $cpf = str_replace(['.', '-'], '', $user->cpf);
        $cep = str_replace('.', '-', $endereco->cep);
        $celular_str = str_replace(['(', ')',' ','-'], '', $user->celular);

        $ddd = substr($celular_str, 0, 2);
        $celular = substr($celular_str, 2, 9);

        $email_pagseguro = env('EMAIL_PAGSEGURO');
        $token_pagseguro = env('TOKEN_PAGSEGURO');
        $url_notificacao = env('URL_NOTIFICACAO');
        $email_loja = env('EMAIL_LOJA');
        $moeda_pagamento = env('MOEDA_PAGAMENTO');
        $billingAddressCountry = env('BILLINGADDRESSCOUNTRY');

        $dados_pagseguro = [

            'email' => $email_pagseguro,
            'token' => $token_pagseguro,
            'receiverEmail' => $email_loja,
            'notificationURL' => $url_notificacao,
            'billingAddressCountry' => $billingAddressCountry,
            "paymentMode" => "default",
            "paymentMethod" => "boleto",

            'senderHash' => $request->hashBoleto, //hash gerado pelo pagseguro
            'installmentValue' => strval($request->valorParcela), //valor da parcela
            'extraAmount' => number_format(0, 2, '.', ''),  

            'shippingAddressRequired' => False,
            'currency' => $moeda_pagamento,
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

        Log::info('Pagamento Nacional | Pagamento efetuado'. json_encode($response));

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
            
            
            Log::info('Pagamento Nacional boleto | Pagamento efetuado com sucesso'. json_encode($pagamento));
            
            return response()->json(['message' => 'success', 'response' => $response], 201);
        }

        Log::info('Pagamento Nacional boleto | Erro ao efetuar pagamento'. json_encode($response));
        return response()->json(['message' => 'error', 'response' => $response], 201);

    }


    public function retorno(Request $request)
    {
        header( "access-control-allow-origin: https://pagseguro.uol.com.br");
        header( "Access-Control-Allow-Headers:*");
        header( "Access-Control-Allow-Method:*");

        if (!isset($request->notificationCode) || $request->notificationType != 'transaction') {

            Log::info('RETORNO | Erro ao receber retorno do pagseguro'. json_encode($request->all()));
            $msg = "notificationCode ou notificationType não possuem valor";
            exit;
        }

        Log::info('RETORNO | request'. json_encode($request->all()));
    
        $notificationCode = preg_replace('/[^[:alnum:]-]/','',$request->notificationCode);	
        $url = env('RETORNO_PAGSEGURO').$notificationCode.'?email='.env('EMAIL_PAGSEGURO').'&token='.env('TOKEN_PAGSEGURO');

        Log::info('RETORNO | URL de retorno do pagseguro'. json_encode($url));
        
        $curl = curl_init($url);	
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);	
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);	
        $xml= curl_exec($curl);	
        curl_close($curl);
    
        if($xml == 'Unauthorized'){

            Log::info('RETORNO | Unauthorized');

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
        
                Log::info('RETORNO | Pagamento atualizado com sucesso'. json_encode($pagamento));

            }else{
                Log::info('RETORNO | Pagamento já atualizado'. json_encode($pagamento));
            }
        } else {
            Log::info('RETORNO | Erro ao atualizar pagamento'. json_encode($xml));
        }  
        return response()->json($xml, 200);
    }
}

    // public function pagamento()
    // {
    //     $url = env('URL_PAGSEGURO') . "sessions?email=" . env('EMAIL_PAGSEGURO') . "&token=" . env('TOKEN_PAGSEGURO');

	
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
    //     curl_setopt($curl, CURLOPT_POST, 1);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     $retorno = curl_exec($curl);
    //     curl_close($curl);
        
    //     Log::info($retorno);

    //     $xml = simplexml_load_string($retorno);
    //     echo json_encode($xml);
    
    // }

    // public function associadocredito(Request $request)
    // { 
    //     $post = $request->all();
    //     $post['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $post['data_nascimento'])->format('Y-m-d');
    //     unset($post['password']);
    //     $user = User::findOrFail($post['id']);

    //     if(!empty($user))
    //     {
    //         if($user->rg == $post['rg']) {
    //             $user->update([
    //                 'name' => $post['name'],
    //                 'telefone' => $post['telefone'],
    //                 'celular' => $post['celular'],
    //                 'data_nascimento' => $post['data_nascimento'],
    //                 'sexo_id' => $post['sexo_id'],
    //                 'updated_at' => Carbon::now()
    //             ]);
    //         }else{

    //             $user->update([
    //                 'name' => $post['name'],
    //                 'telefone' => $post['telefone'],
    //                 'celular' => $post['celular'],
    //                 'data_nascimento' => $post['data_nascimento'],
    //                 'rg' => $post['rg'],
    //                 'orgao_expedidor' => $post['orgao_expedidor'],
    //                 'sexo_id' => $post['sexo_id'],
    //                 'updated_at' => Carbon::now()
    //             ]);
    //         }
    //     }

    //     $associado = Associado::whereUserId($user->id)->first();   

    //     if(empty($associado))
    //     {
    //         $associado = Associado::create(
    //             [
    //                 'user_id' => $user->id,
    //                 'instituicao_id' => $request->instituicao_id,
    //                 'titulacao_id' => $request->titulacao_id,
    //             ]
    //         );

    //     }else
    //     {
    //         $associado->update(
    //             [
    //                 'user_id' => $user->id,
    //                 'instituicao_id' => $request->instituicao_id,
    //                 'titulacao_id' => $request->titulacao_id,
    //             ]
    //         );    
    //     }

    //     $endereco = Endereco::whereUserId($user->id)->first();   

    //     if(empty($endereco))
    //     {
    //         $endereco = Endereco::create(
    //             [
    //                 'user_id' => $user->id,
    //                 'logradouro' => $request->logradouro,
    //                 'numero' => $request->numero,
    //                 'complemento' => $request->complemento,
    //                 'bairro' => $request->bairro,
    //                 'municipio_id' => $request->municipio,
    //                 'cep' => $request->cep,
    //                 'pais_id' => $request->pais,
    //                 'updated_at' => Carbon::now()
    //             ]
    //         );
    
    //     }else {
    //         $endereco->update(
    //             [
    //                 'user_id' => $user->id,
    //                 'logradouro' => $request->logradouro,
    //                 'numero' => $request->numero,
    //                 'complemento' => $request->complemento,
    //                 'bairro' => $request->bairro,
    //                 'municipio_id' => $request->municipio,
    //                 'cep' => $request->cep,
    //                 'pais_id' => $request->pais,
    //                 'updated_at' => Carbon::now()
    //             ]
    //         );
    //     }

    //     Log::info('Cadastro de usuario: ' . json_encode($user));

    //     if(!empty($request->associado) && $request->associado == 1){
    //         $produto = Produto::findOrFail(1);
    //     }

    //     if(!empty($request->anuidade2022) && $request->anuidade2022 == 1){
    //         $produto = Produto::findOrFail(2);
    //     }

    //     $venda = Venda::create(['user_id' => $user['id']]);
    //     Log::info('Venda efetuada  com sucesso'. json_encode($venda));

    //     $venda_item = VendaItem::create([
    //         'venda_id' => $venda->id, 
    //         'produto_id' => $produto->id, 
    //         'qtd' => $request->parcelas ?? 1, 
    //         'valor' => $produto->valor, 
    //         'valor_total' => $produto->valor * $request->parcelas ?? 1
    //     ]);
    //     Log::info('Venda de  item efetuado com sucesso'. json_encode($venda_item));

    //     //Formatação de dados para o PagSeguro
    //     $cpf = str_replace(['.', '-'], '', $user->cpf);
    //     $cep = str_replace('.', '-', $request->cep);
    //     $celular_str = str_replace(['(', ')',' ','-'], '', $request->celular);

    //     $ddd = substr($celular_str, 0, 2);
    //     $celular = substr($celular_str, 2, 9);

    //     $email_pagseguro = env('EMAIL_PAGSEGURO');
    //     $token_pagseguro = env('TOKEN_PAGSEGURO');
    //     $url_notificacao = env('URL_NOTIFICACAO');

    //     $dados_pagseguro = [
    //         'email' => $email_pagseguro,
    //         'token' => $token_pagseguro,
    //         'receiverEmail' => $email_pagseguro,
    //         'notificationURL' => $url_notificacao,
    //         'billingAddressCountry' => 'Brasil',
    //         "paymentMode" => "default",
    //         "paymentMethod" => "creditCard",
    //         //fazer chamada para o metodo de pagamento
    //         "creditCardToken" => $request->tokenCartao, //token do cartao
    //         'senderHash' => $request->hashCartao, //hash gerado pelo pagseguro
    //         'installmentQuantity' => $request->parcelas, //quantidade de parcelas
    //         'installmentValue' => strval($request->valorParcela), //valor da parcela
    //         'extraAmount' => number_format(0, 2, '.', ''),    
    //         'creditCardHolderName' => $user->name ,
    //         'creditCardHolderCPF' => $cpf,
    //         'creditCardHolderBirthDate' => '01/01/2000',
    //         // 'creditCardHolderBirthDate' => $user->data_nascimento ?? '01/01/2000',
    //         'creditCardHolderAreaCode' => $ddd,
    //         'creditCardHolderPhone' => $celular,
    //         'billingAddressStreet' => $request->logradouro,
    //         'billingAddressNumber' => "0",
    //         'billingAddressComplement' => "",
    //         'billingAddressDistrict' => $request->bairro,
    //         'billingAddressPostalCode' => $cep,
    //         'billingAddressCity' => $endereco['municipio']['nome'],
    //         'billingAddressState' => $endereco['estado']['sigla'],
    //         'shippingAddressRequired' => False,
    //         'currency' => 'BRL',
    //         'itemId1' => $venda_item->id,
    //         'itemDescription1' => $produto->nome,
    //         'itemAmount1' => number_format($produto->valor, 2, '.', ''),
    //         'itemQuantity1' => 1,
    //         'reference' => $venda->id,
    //         'senderName' => $user->name,
    //         'senderCPF' => $cpf,
    //         'senderAreaCode' => $ddd,
    //         'senderPhone' => $celular,
    //         'senderEmail' => $user->email,
    //     ];

    //     $buildQuery = http_build_query($dados_pagseguro);
    //     $url = env('URL_PAGSEGURO') . "transactions";
    
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
    //     curl_setopt($curl, CURLOPT_POST, true);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
    //     $retornoxml = curl_exec($curl);
    //     curl_close($curl);      
    //     $response = simplexml_load_string($retornoxml);

    //     Log::info('Pagamento efetuado'. json_encode($response));

    //     $codigo_venda = intval($response->reference);
    //     $codigo_tipo_pagto = intval($response->paymentMethod->type);
    //     $codigo_tipo_pagto_detalhe = $response->paymentMethod->code;
    //     $transacao = $response->code;
    //     $valor_venda = floatval($produto->valor);
    //     $parcelas = intval($request->parcelas);
    //     $valor_parcela = floatval($request->valorParcela);
    //     $valor_total = floatval($parcelas * $valor_parcela);
    //     $valor_juros = floatval($valor_total - $valor_venda);
    //     $valor_receber = floatval($response->netAmount);
    //     $codigo_status = intval($response->status);

    //     if(!$response->error){
     
    //         $pagamento = PagSeguroPgto::create([
    //             'tipo_pgto_detalhe' => $codigo_tipo_pagto_detalhe,
    //             'transacao' => $transacao,
    //             'parcelas' => $parcelas,
    //             'valor_parcela' => $valor_parcela,
    //             'valor_total' => $valor_total,
    //             'valor_juros' => $valor_juros,
    //             'valor_receber' => $valor_receber,
    //             'venda_id' => $codigo_venda,
    //             'tipo_pagto_id' => $codigo_tipo_pagto,
    //             'status_id' => $codigo_status,
    //             'user_id' => $user['id'],
    //         ]);
            
    //         Log::info('Pagamento efetuado com sucesso'. json_encode($pagamento));
            
    //         return response()->json(['message' => 'success', 'response' => $pagamento], 201);
    //     }

    //     Log::info('Erro ao efetuar pagamento'. json_encode($response));
    //     return response()->json(['message' => 'error', 'response' => $response], 201);

    // }

    // public function associadoboleto(Request $request)
    // {
    //     $post = $request->all();
    //     $post['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $post['data_nascimento'])->format('Y-m-d');
    //     unset($post['password']);
    //     $user = User::findOrFail($post['id']);
    
    //     if(!empty($user))
    //     {
    //         if($user->rg == $post['rg']) {
    //             $user->update([
    //                 'name' => $post['name'],
    //                 'telefone' => $post['telefone'],
    //                 'celular' => $post['celular'],
    //                 'data_nascimento' => $post['data_nascimento'],
    //                 'sexo_id' => $post['sexo_id'],
    //                 'updated_at' => Carbon::now()
    //             ]);
    //         }else{
    
    //             $user->update([
    //                 'name' => $post['name'],
    //                 'telefone' => $post['telefone'],
    //                 'celular' => $post['celular'],
    //                 'data_nascimento' => $post['data_nascimento'],
    //                 'rg' => $post['rg'],
    //                 'orgao_expedidor' => $post['orgao_expedidor'],
    //                 'sexo_id' => $post['sexo_id'],
    //                 'updated_at' => Carbon::now()
    //             ]);
    //         }
    //     }
    
    
    //     $associado = Associado::whereUserId($user->id)->first();   
        
    //     if(empty($associado))
    //     {
    //         $associado = Associado::create(
    //             [
    //                 'user_id' => $user->id,
    //                 'instituicao_id' => $request->instituicao_id,
    //                 'titulacao_id' => $request->titulacao_id,
    //             ]
    //         );
    
    //     }else
    //     {
    //         $associado->update(
    //             [
    //                 'user_id' => $user->id,
    //                 'instituicao_id' => $request->instituicao_id,
    //                 'titulacao_id' => $request->titulacao_id,
    //             ]
    //         );    
    //     }
    
    //     $endereco = Endereco::whereUserId($user->id)->first();   
    
    //     if(empty($endereco))
    //     {
    //         $endereco = Endereco::create(
    //             [
    //                 'user_id' => $user->id,
    //                 'logradouro' => $request->logradouro,
    //                 'numero' => $request->numero,
    //                 'complemento' => $request->complemento,
    //                 'bairro' => $request->bairro,
    //                 'municipio_id' => $request->municipio,
    //                 'cep' => $request->cep,
    //                 'pais_id' => $request->pais,
    //                 'updated_at' => Carbon::now()
    //             ]
    //         );
    
    //     }else {
    //         $endereco->update(
    //             [
    //                 'user_id' => $user->id,
    //                 'logradouro' => $request->logradouro,
    //                 'numero' => $request->numero,
    //                 'complemento' => $request->complemento,
    //                 'bairro' => $request->bairro,
    //                 'municipio_id' => $request->municipio,
    //                 'cep' => $request->cep,
    //                 'pais_id' => $request->pais,
    //                 'updated_at' => Carbon::now()
    //             ]
    //         );
    //     }
    
    //     Log::info('Cadastro de usuario: ' . json_encode($user));

    //     if(!empty($request->associado) && $request->associado == 1){
    //         $produto = Produto::findOrFail(1);
    //     }

    //     if(!empty($request->anuidade2022) && $request->anuidade2022 == 1){
    //         $produto = Produto::findOrFail(2);
    //     }


    //     $venda = Venda::create(['user_id' => $user['id']]);
    //     Log::info('Venda efetuada  com sucesso'. json_encode($venda));
        
    //     $venda_item = VendaItem::create([
    //         'venda_id' => $venda->id, 
    //         'produto_id' => $produto->id, 
    //         'qtd' => $request->parcelas ?? 1, 
    //         'valor' => $produto->valor, 
    //         'valor_total' => $produto->valor
    //     ]);
    //     Log::info('Venda de  item efetuado com sucesso'. json_encode($venda_item));

    //     //Formatação de dados para o PagSeguro
    //     $cpf = str_replace(['.', '-'], '', $user->cpf);
    //     $cep = str_replace('.', '-', $endereco->cep);
    //     $celular_str = str_replace(['(', ')',' ','-'], '', $request->celular);

    //     $ddd = substr($celular_str, 0, 2);
    //     $celular = substr($celular_str, 2, 9);

    //     $email_pagseguro = env('EMAIL_PAGSEGURO');
    //     $token_pagseguro = env('TOKEN_PAGSEGURO');
    //     $url_notificacao = env('URL_NOTIFICACAO');
    //     $email_loja = env('EMAIL_LOJA');
    //     $moeda_pagamento = env('MOEDA_PAGAMENTO');
    //     $billingAddressCountry = env('BILLINGADDRESSCOUNTRY');

        
    //     $dados_pagseguro = [
            
    //         'email' => $email_pagseguro,
    //         'token' => $token_pagseguro,
    //         'receiverEmail' => $email_loja,
    //         'notificationURL' => $url_notificacao,
    //         'billingAddressCountry' => $billingAddressCountry,
    //         "paymentMode" => "default",
    //         "paymentMethod" => "boleto",
            
    //         'senderHash' => $request->hashBoleto, //hash gerado pelo pagseguro
    //         'installmentValue' => strval($request->valorParcela), //valor da parcela
    //         'extraAmount' => number_format(0, 2, '.', ''),  
            
    //         'shippingAddressRequired' => False,
    //         'currency' => $moeda_pagamento,
    //         'itemId1' => $venda_item->id,
    //         'itemDescription1' => $produto->nome,
    //         'itemAmount1' => number_format($produto->valor, 2, '.', ''),
    //         'itemQuantity1' => 1,
    //         'reference' => $venda->id,
    //         'senderName' => $user->name,
    //         'senderCPF' => $cpf,
    //         'senderAreaCode' => $ddd,
    //         'senderPhone' => $celular,
    //         'senderEmail' => $user->email,
    //     ];

    //     $buildQuery = http_build_query($dados_pagseguro);
    //     $url = env('URL_PAGSEGURO') . "transactions";
        
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
    //     curl_setopt($curl, CURLOPT_POST, true);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
    //     $retornoxml = curl_exec($curl);
    //     curl_close($curl);      
    //     $response = simplexml_load_string($retornoxml);
        
    //     Log::info('Pagamento efetuado'. json_encode($response));

    //     $codigo_venda = intval($response->reference);
    //     $codigo_tipo_pagto = intval($response->paymentMethod->type);
    //     $codigo_tipo_pagto_detalhe = $response->paymentMethod->code;
    //     $transacao = $response->code;
    //     $valor_venda = floatval($produto->valor);
    //     $parcelas = intval($request->parcelas);
    //     $valor_parcela = floatval($request->valorParcela);
    //     $valor_total = floatval($parcelas * $valor_parcela);
    //     $valor_juros = floatval($valor_total - $valor_venda);
    //     $valor_receber = floatval($response->netAmount);
    //     $codigo_status = intval($response->status);

    //     if(!$response->error){
     
    //         $pagamento = PagSeguroPgto::create([
    //             'tipo_pgto_detalhe' => $codigo_tipo_pagto_detalhe,
    //             'transacao' => $transacao,
    //             'parcelas' => $parcelas,
    //             'valor_parcela' => $valor_parcela,
    //             'valor_total' => $valor_total,
    //             'valor_juros' => $valor_juros,
    //             'valor_receber' => $valor_receber,
    //             'venda_id' => $codigo_venda,
    //             'tipo_pagto_id' => $codigo_tipo_pagto,
    //             'status_id' => $codigo_status,
    //             'user_id' => $user['id'],
    //         ]);
                        
    //         Log::info('Pagamento efetuado com sucesso'. json_encode($pagamento));
            
    //         return response()->json(['message' => 'success', 'response' => $response], 201);
    //     }

    //     Log::info('Erro ao efetuar pagamento'. json_encode($response));
    //     return response()->json(['message' => 'error', 'response' => $response], 201);
        
    // }
    
    // public function associadocreditoanuidade(Request $request)
    // { 

    //     $post = $request->all();
    //     $post['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $post['data_nascimento'])->format('Y-m-d');
    //     unset($post['password']);
    //     $user = User::findOrFail($post['id']);
    
    //     if(!empty($user))
    //     {
    //         if($user->rg == $post['rg']) {
    //             $user->update([
    //                 'name' => $post['name'],
    //                 'telefone' => $post['telefone'],
    //                 'celular' => $post['celular'],
    //                 'data_nascimento' => $post['data_nascimento'],
    //                 'sexo_id' => $post['sexo_id'],
    //                 'updated_at' => Carbon::now()
    //             ]);
    //         }else{
    
    //             $user->update([
    //                 'name' => $post['name'],
    //                 'telefone' => $post['telefone'],
    //                 'celular' => $post['celular'],
    //                 'data_nascimento' => $post['data_nascimento'],
    //                 'rg' => $post['rg'],
    //                 'orgao_expedidor' => $post['orgao_expedidor'],
    //                 'sexo_id' => $post['sexo_id'],
    //                 'updated_at' => Carbon::now()
    //             ]);
    //         }
    //     }

    //     $endereco = Endereco::whereUserId($user->id)->first();   
    
    //     if(empty($endereco))
    //     {
    //         $endereco = Endereco::create(
    //             [
    //                 'user_id' => $user->id,
    //                 'logradouro' => $request->logradouro,
    //                 'numero' => $request->numero,
    //                 'complemento' => $request->complemento,
    //                 'bairro' => $request->bairro,
    //                 'municipio_id' => $request->municipio,
    //                 'cep' => $request->cep,
    //                 'pais_id' => $request->pais,
    //                 'updated_at' => Carbon::now()
    //             ]
    //         );
    
    //     }else {
    //         $endereco->update(
    //             [
    //                 'user_id' => $user->id,
    //                 'logradouro' => $request->logradouro,
    //                 'numero' => $request->numero,
    //                 'complemento' => $request->complemento,
    //                 'bairro' => $request->bairro,
    //                 'municipio_id' => $request->municipio,
    //                 'cep' => $request->cep,
    //                 'pais_id' => $request->pais,
    //                 'updated_at' => Carbon::now()
    //             ]
    //         );
    //     }
    
    //     Log::info('Pagamento anuidade credito | Dados do Usuario salvo: ' . json_encode($user));
    
    
    //     $associado = Associado::whereUserId($user->id)->first();   
        
    //     if(!empty($associado))
    //     {
    //         $date = Carbon::now();
    //         $date = date('Y', strtotime($date));

    //         $associado->update( ['anuidade' => $date ]);
    //     }

    //     Log::info('Pagamento anuidade credito | Associado atualizado : ' . json_encode($associado));
    
    //     if(!empty($request->anuidade2022) && $request->anuidade2022 == 1){
    //         $produto = Produto::findOrFail(2);
    //     }

    //     $venda = Venda::create(['user_id' => $user['id']]);
    //     Log::info('Pagamento anuidade credito | Venda efetuada  com sucesso'. json_encode($venda));

    //     $venda_item = VendaItem::create([
    //         'venda_id' => $venda->id, 
    //         'produto_id' => $produto->id, 
    //         'qtd' => $request->parcelas ?? 1, 
    //         'valor' => $produto->valor, 
    //         'valor_total' => $produto->valor
    //     ]);
    //     Log::info('Pagamento anuidade credito | Venda de  item efetuado com sucesso'. json_encode($venda_item));

    //     //Formatação de dados para o PagSeguro
    //     $cpf = str_replace(['.', '-'], '', $user->cpf);
    //     $cep = str_replace('.', '-', $user->enderecos[0]->cep);
    //     $celular_str = str_replace(['(', ')',' ','-'], '', $user->celular);

    //     $ddd = substr($celular_str, 0, 2);
    //     $celular = substr($celular_str, 2, 9);

    //     $email_pagseguro = env('EMAIL_PAGSEGURO');
    //     $token_pagseguro = env('TOKEN_PAGSEGURO');
    //     $url_notificacao = env('URL_NOTIFICACAO');

    //     $dados_pagseguro = [

    //         'email' => $email_pagseguro,
    //         'token' => $token_pagseguro,
    //         'receiverEmail' => $email_pagseguro,
    //         'notificationURL' => $url_notificacao,
    //         'billingAddressCountry' => 'Brasil',
    //         "paymentMode" => "default",
    //         "paymentMethod" => "creditCard",
    //         //fazer chamada para o metodo de pagamento
    //         "creditCardToken" => $request->tokenCartao, //token do cartao
    //         'senderHash' => $request->hashCartao, //hash gerado pelo pagseguro
    //         'installmentQuantity' => $request->parcelas, //quantidade de parcelas
    //         'installmentValue' => strval($request->valorParcela), //valor da parcela
    //         'extraAmount' => number_format(0, 2, '.', ''),    
    //         'creditCardHolderName' => $user->name ,
    //         'creditCardHolderCPF' => $cpf,
    //         'creditCardHolderBirthDate' => '01/01/2000',
    //         // 'creditCardHolderBirthDate' => $user->data_nascimento ?? '01/01/2000',
    //         'creditCardHolderAreaCode' => $ddd,
    //         'creditCardHolderPhone' => $celular,
    //         'billingAddressStreet' => $user->enderecos[0]->logradouro,
    //         'billingAddressNumber' => $user->enderecos[0]->numero,
    //         'billingAddressComplement' => "",
    //         'billingAddressDistrict' => $user->enderecos[0]->bairro,
    //         'billingAddressPostalCode' => $cep,
    //         'billingAddressCity' => $user->enderecos[0]['municipio']['nome'],
    //         'billingAddressState' => $user->enderecos[0]['estado']['sigla'],
    //         'shippingAddressRequired' => False,
    //         'currency' => 'BRL',
    //         'itemId1' => $venda_item->id,
    //         'itemDescription1' => $produto->nome,
    //         'itemAmount1' => number_format($produto->valor, 2, '.', ''),
    //         'itemQuantity1' => 1,
    //         'reference' => $venda->id,
    //         'senderName' => $user->name,
    //         'senderCPF' => $cpf,
    //         'senderAreaCode' => $ddd,
    //         'senderPhone' => $celular,
    //         'senderEmail' => $user->email,
    //     ];

    //     Log::info('Pagamento anuidade credito | Dados para pagamento enviados ao PagSeguro'. json_encode($dados_pagseguro));

    //     $buildQuery = http_build_query($dados_pagseguro);
    //     $url = env('URL_PAGSEGURO') . "transactions";
    
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
    //     curl_setopt($curl, CURLOPT_POST, true);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
    //     $retornoxml = curl_exec($curl);
    //     curl_close($curl);      
    //     $response = simplexml_load_string($retornoxml);

    //     Log::info('Pagamento anuidade credito | Pagamento efetuado'. json_encode($response));

    //     $codigo_venda = intval($response->reference);
    //     $codigo_tipo_pagto = intval($response->paymentMethod->type);
    //     $codigo_tipo_pagto_detalhe = $response->paymentMethod->code;
    //     $transacao = $response->code;
    //     $valor_venda = floatval($produto->valor);
    //     $parcelas = intval($request->parcelas);
    //     $valor_parcela = floatval($request->valorParcela);
    //     $valor_total = floatval($parcelas * $valor_parcela);
    //     $valor_juros = floatval($valor_total - $valor_venda);
    //     $valor_receber = floatval($response->netAmount);
    //     $codigo_status = intval($response->status);

    //     if(!$response->error){
     
    //         $pagamento = PagSeguroPgto::create([
    //             'tipo_pgto_detalhe' => $codigo_tipo_pagto_detalhe,
    //             'transacao' => $transacao,
    //             'parcelas' => $parcelas,
    //             'valor_parcela' => $valor_parcela,
    //             'valor_total' => $valor_total,
    //             'valor_juros' => $valor_juros,
    //             'valor_receber' => $valor_receber,
    //             'venda_id' => $codigo_venda,
    //             'tipo_pagto_id' => $codigo_tipo_pagto,
    //             'status_id' => $codigo_status,
    //             'user_id' => $user['id'],
    //         ]);
                        
    //         Log::info('Pagamento anuidade credito | Pagamento efetuado com sucesso'. json_encode($pagamento));
            
    //         return response()->json(['message' => 'success', 'response' => $user], 201);
    //     }

    //     Log::info('Pagamento anuidade credito | Erro ao efetuar pagamento'. json_encode($response));
    //     return response()->json(['message' => 'error', 'response' => $response], 201);

    // }

    // public function associadoboletoanuidade(Request $request)
    // {
    //     $post = $request->all();
    //     $post['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $post['data_nascimento'])->format('Y-m-d');
    //     unset($post['password']);
    //     $user = User::findOrFail($post['id']);
    
    //     if(!empty($user))
    //     {
    //         if($user->rg == $post['rg']) {
    //             $user->update([
    //                 'name' => $post['name'],
    //                 'telefone' => $post['telefone'],
    //                 'celular' => $post['celular'],
    //                 'data_nascimento' => $post['data_nascimento'],
    //                 'sexo_id' => $post['sexo_id'],
    //                 'updated_at' => Carbon::now()
    //             ]);
    //         }else{
    
    //             $user->update([
    //                 'name' => $post['name'],
    //                 'telefone' => $post['telefone'],
    //                 'celular' => $post['celular'],
    //                 'data_nascimento' => $post['data_nascimento'],
    //                 'rg' => $post['rg'],
    //                 'orgao_expedidor' => $post['orgao_expedidor'],
    //                 'sexo_id' => $post['sexo_id'],
    //                 'updated_at' => Carbon::now()
    //             ]);
    //         }
    //     }

    //     $endereco = Endereco::whereUserId($user->id)->first();   
    
    //     if(empty($endereco))
    //     {
    //         $endereco = Endereco::create(
    //             [
    //                 'user_id' => $user->id,
    //                 'logradouro' => $request->logradouro,
    //                 'numero' => $request->numero,
    //                 'complemento' => $request->complemento,
    //                 'bairro' => $request->bairro,
    //                 'municipio_id' => $request->municipio,
    //                 'cep' => $request->cep,
    //                 'pais_id' => $request->pais,
    //                 'updated_at' => Carbon::now()
    //             ]
    //         );
    
    //     }else {
    //         $endereco->update(
    //             [
    //                 'user_id' => $user->id,
    //                 'logradouro' => $request->logradouro,
    //                 'numero' => $request->numero,
    //                 'complemento' => $request->complemento,
    //                 'bairro' => $request->bairro,
    //                 'municipio_id' => $request->municipio,
    //                 'cep' => $request->cep,
    //                 'pais_id' => $request->pais,
    //                 'updated_at' => Carbon::now()
    //             ]
    //         );
    //     }
    
    //     Log::info('Pagamento anuidade boleto | Dados do Usuario salvo: ' . json_encode($user));

    //     $associado = Associado::whereUserId($user->id)->first();   
        
    //     if(!empty($associado))
    //     {
    //         $date = Carbon::now();
    //         $date = date('Y', strtotime($date));

    //         $associado->update( ['anuidade' => $date ]);
    //     }

    //     Log::info('Pagamento anuidade boleto | Anuidade atualizada : ' . json_encode($associado));

    //     if(!empty($request->associado) && $request->associado == 1){
    //         $produto = Produto::findOrFail(1);
    //     }

    //     if(!empty($request->anuidade2022) && $request->anuidade2022 == 1){
    //         $produto = Produto::findOrFail(2);
    //     }

    //     $venda = Venda::create(['user_id' => $user['id']]);
    //     Log::info('Pagamento anuidade boleto | Venda efetuada  com sucesso'. json_encode($venda));

    //     $venda_item = VendaItem::create([
    //         'venda_id' => $venda->id, 
    //         'produto_id' => $produto->id, 
    //         'qtd' => $request->parcelas ?? 1, 
    //         'valor' => $produto->valor, 
    //         'valor_total' => $produto->valor
    //     ]);
    //     Log::info('Pagamento anuidade boleto | Venda de  item efetuado com sucesso'. json_encode($venda_item));

    //     //Formatação de dados para o PagSeguro
    //     $cpf = str_replace(['.', '-'], '', $user->cpf);
    //     $cep = str_replace('.', '-', $user->enderecos[0]->cep);
    //     $celular_str = str_replace(['(', ')',' ','-'], '', $user->celular);

    //     $ddd = substr($celular_str, 0, 2);
    //     $celular = substr($celular_str, 2, 9);

    //     $email_pagseguro = env('EMAIL_PAGSEGURO');
    //     $token_pagseguro = env('TOKEN_PAGSEGURO');
    //     $url_notificacao = env('URL_NOTIFICACAO');
    //     $email_loja = env('EMAIL_LOJA');
    //     $moeda_pagamento = env('MOEDA_PAGAMENTO');
    //     $billingAddressCountry = env('BILLINGADDRESSCOUNTRY');


    //     $dados_pagseguro = [

    //         'email' => $email_pagseguro,
    //         'token' => $token_pagseguro,
    //         'receiverEmail' => $email_loja,
    //         'notificationURL' => $url_notificacao,
    //         'billingAddressCountry' => $billingAddressCountry,
    //         "paymentMode" => "default",
    //         "paymentMethod" => "boleto",

    //         'senderHash' => $request->hashBoleto, //hash gerado pelo pagseguro
    //         'installmentValue' => strval($request->valorParcela), //valor da parcela
    //         'extraAmount' => number_format(0, 2, '.', ''),  

    //         'shippingAddressRequired' => False,
    //         'currency' => $moeda_pagamento,
    //         'itemId1' => $venda_item->id,
    //         'itemDescription1' => $produto->nome,
    //         'itemAmount1' => number_format($produto->valor, 2, '.', ''),
    //         'itemQuantity1' => 1,
    //         'reference' => $venda->id,
    //         'senderName' => $user->name,
    //         'senderCPF' => $cpf,
    //         'senderAreaCode' => $ddd,
    //         'senderPhone' => $celular,
    //         'senderEmail' => $user->email,
    //     ];

    //     $buildQuery = http_build_query($dados_pagseguro);
    //     $url = env('URL_PAGSEGURO') . "transactions";
    
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
    //     curl_setopt($curl, CURLOPT_POST, true);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
    //     $retornoxml = curl_exec($curl);
    //     curl_close($curl);      
    //     $response = simplexml_load_string($retornoxml);

    //     Log::info('Pagamento anuidade boleto | Pagamento efetuado'. json_encode($response));

    //     $codigo_venda = intval($response->reference);
    //     $codigo_tipo_pagto = intval($response->paymentMethod->type);
    //     $codigo_tipo_pagto_detalhe = $response->paymentMethod->code;
    //     $transacao = $response->code;
    //     $valor_venda = floatval($produto->valor);
    //     $parcelas = intval($request->parcelas);
    //     $valor_parcela = floatval($request->valorParcela);
    //     $valor_total = floatval($parcelas * $valor_parcela);
    //     $valor_juros = floatval($valor_total - $valor_venda);
    //     $valor_receber = floatval($response->netAmount);
    //     $codigo_status = intval($response->status);

    //     if(!$response->error){
     
    //         $pagamento = PagSeguroPgto::create([
    //             'tipo_pgto_detalhe' => $codigo_tipo_pagto_detalhe,
    //             'transacao' => $transacao,
    //             'parcelas' => $parcelas,
    //             'valor_parcela' => $valor_parcela,
    //             'valor_total' => $valor_total,
    //             'valor_juros' => $valor_juros,
    //             'valor_receber' => $valor_receber,
    //             'venda_id' => $codigo_venda,
    //             'tipo_pagto_id' => $codigo_tipo_pagto,
    //             'status_id' => $codigo_status,
    //             'user_id' => $user['id'],
    //         ]);
            
            
    //         Log::info('Pagamento anuidade boleto | Pagamento efetuado com sucesso'. json_encode($pagamento));
            
    //         return response()->json(['message' => 'success', 'response' => $response], 201);
    //     }

    //     Log::info('Pagamento anuidade boleto | Erro ao efetuar pagamento'. json_encode($response));
    //     return response()->json(['message' => 'error', 'response' => $response], 201);

    // }

    // public function regionaiscredito(Request $request)
    // { 
    //     $post = $request->all();
    //     unset($post['password']);
    //     unset($post['numCartao']);
    //     unset($post['cvv']);
    //     unset($post['validade']);
        
    //     $user = User::findOrFail($post['id']);

    //     $produto = Produto::findOrFail($post['produto']);
    //     $endereco = $user->enderecos()->first();
    //     $municipio = Municipio::findOrFail($endereco->municipio_id);
    //     $estado = Estado::findOrFail($municipio->estado_id);

    //     $venda = Venda::create(['user_id' => $user['id']]);
    //     Log::info('Pagamento Regional Sul '.date('Y').' | Venda efetuada  com sucesso'. json_encode($venda));

    //     $venda_item = VendaItem::create([
    //         'venda_id' => $venda->id, 
    //         'produto_id' => $produto->id, 
    //         'qtd' => $post['parcelas'] ?? 1, 
    //         'valor' => $produto->valor, 
    //         'valor_total' => $produto->valor
    //     ]);
    //     Log::info('Pagamento '.date('Y').' | Venda de  item efetuado com sucesso'. json_encode($venda_item));

    //     //Formatação de dados para o PagSeguro
    //     $cpf = str_replace(['.', '-'], '', $user->cpf);
    //     $cep = str_replace('.', '-', $endereco->cep);
    //     $celular_str = str_replace(['(', ')',' ','-'], '', $user->celular);

    //     $ddd = substr($celular_str, 0, 2);
    //     $celular = substr($celular_str, 2, 9);

    //     $email_pagseguro = env('EMAIL_PAGSEGURO');
    //     $token_pagseguro = env('TOKEN_PAGSEGURO');
    //     $url_notificacao = env('URL_NOTIFICACAO');

    //     $dados_pagseguro = [

    //         'email' => $email_pagseguro,
    //         'token' => $token_pagseguro,
    //         'receiverEmail' => $email_pagseguro,
    //         'notificationURL' => $url_notificacao,
    //         'billingAddressCountry' => 'Brasil',
    //         "paymentMode" => "default",
    //         "paymentMethod" => "creditCard",
    //         //fazer chamada para o metodo de pagamento
    //         "creditCardToken" => $request->tokenCartao, //token do cartao
    //         'senderHash' => $request->hashCartao, //hash gerado pelo pagseguro
    //         'installmentQuantity' => $request->parcelas, //quantidade de parcelas
    //         'installmentValue' => strval($request->valorParcela), //valor da parcela
    //         'extraAmount' => number_format(0, 2, '.', ''),    
    //         'creditCardHolderName' => $user->name ,
    //         'creditCardHolderCPF' => $cpf,
    //         'creditCardHolderBirthDate' => '01/01/2000',
    //         // 'creditCardHolderBirthDate' => $user->data_nascimento ?? '01/01/2000',
    //         'creditCardHolderAreaCode' => $ddd,
    //         'creditCardHolderPhone' => $celular,
    //         'billingAddressStreet' => $endereco->logradouro,
    //         'billingAddressNumber' => $endereco->numero,
    //         'billingAddressComplement' => "",
    //         'billingAddressDistrict' => $endereco->bairro,
    //         'billingAddressPostalCode' => $cep,
    //         'billingAddressCity' => $municipio['nome'],
    //         'billingAddressState' => $estado['sigla'],
    //         'shippingAddressRequired' => False,
    //         'currency' => 'BRL',
    //         'itemId1' => $venda_item->id,
    //         'itemDescription1' => $produto->nome,
    //         'itemAmount1' => number_format($produto->valor, 2, '.', ''),
    //         'itemQuantity1' => 1,
    //         'reference' => $venda->id,
    //         'senderName' => $user->name,
    //         'senderCPF' => $cpf,
    //         'senderAreaCode' => $ddd,
    //         'senderPhone' => $celular,
    //         'senderEmail' => $user->email,
    //     ];

    //     Log::info('Pagamento  '.date('Y').'  | Dados para pagamento enviados ao PagSeguro'. json_encode($dados_pagseguro));

    //     $buildQuery = http_build_query($dados_pagseguro);
    //     $url = env('URL_PAGSEGURO') . "transactions";
    
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
    //     curl_setopt($curl, CURLOPT_POST, true);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
    //     $retornoxml = curl_exec($curl);
    //     curl_close($curl);      
    //     $response = simplexml_load_string($retornoxml);

    //     Log::info('Pagamento '.date('Y').'  | Pagamento efetuado'. json_encode($response));

    //     $codigo_venda = intval($response->reference);
    //     $codigo_tipo_pagto = intval($response->paymentMethod->type);
    //     $codigo_tipo_pagto_detalhe = $response->paymentMethod->code;
    //     $transacao = $response->code;
    //     $valor_venda = floatval($produto->valor);
    //     $parcelas = intval($request->parcelas);
    //     $valor_parcela = floatval($request->valorParcela);
    //     $valor_total = floatval($parcelas * $valor_parcela);
    //     $valor_juros = floatval($valor_total - $valor_venda);
    //     $valor_receber = floatval($response->netAmount);
    //     $codigo_status = intval($response->status);

    //     if(!$response->error){
     
    //         $pagamento = PagSeguroPgto::create([
    //             'tipo_pgto_detalhe' => $codigo_tipo_pagto_detalhe,
    //             'transacao' => $transacao,
    //             'parcelas' => $parcelas,
    //             'valor_parcela' => $valor_parcela,
    //             'valor_total' => $valor_total,
    //             'valor_juros' => $valor_juros,
    //             'valor_receber' => $valor_receber,
    //             'venda_id' => $codigo_venda,
    //             'tipo_pagto_id' => $codigo_tipo_pagto,
    //             'status_id' => $codigo_status,
    //             'user_id' => $user['id'],
    //         ]);
                        
    //         Log::info('Pagamento  '.date('Y').'  | Pagamento efetuado com sucesso'. json_encode($pagamento));

    //         return response()->json(['message' => 'success', 'response' => $user], 201);
    //     }

    //     Log::info('Pagamento '.date('Y').'  | Erro ao efetuar pagamento'. json_encode($response));
    //     return response()->json(['message' => 'error', 'response' => $response], 201);

    // }

    // public function regionaisboleto(Request $request)
    // {
    //     $post = $request->all();
    //     unset($post['password']);
    //     unset($post['password']);
    //     unset($post['numCartao']);
    //     unset($post['cvv']);
    //     unset($post['validade']);
    
    //     $user = User::findOrFail($post['id']);
    //     $produto = Produto::findOrFail($post['produto']['id']);
    //     $endereco = $user->enderecos()->first();
    //     $municipio = Municipio::findOrFail($endereco->municipio_id);
    //     $estado = Estado::findOrFail($municipio->estado_id);
    
    //     $venda = Venda::create(['user_id' => $user['id']]);
    //     Log::info('Pagamento anuidade boleto | Venda efetuada  com sucesso'. json_encode($venda));

    //     $venda_item = VendaItem::create([
    //         'venda_id' => $venda->id, 
    //         'produto_id' => $produto->id, 
    //         'qtd' => $post['parcelas'] ?? 1, 
    //         'valor' => $produto->valor, 
    //         'valor_total' => $produto->valor
    //     ]);
    //     Log::info('Pagamento  '.date('Y').' | Venda de  item efetuado com sucesso'. json_encode($venda_item));

    //     //Formatação de dados para o PagSeguro
    //     $cpf = str_replace(['.', '-'], '', $user->cpf);
    //     $cep = str_replace('.', '-', $endereco->cep);
    //     $celular_str = str_replace(['(', ')',' ','-'], '', $user->celular);

    //     $ddd = substr($celular_str, 0, 2);
    //     $celular = substr($celular_str, 2, 9);

    //     $email_pagseguro = env('EMAIL_PAGSEGURO');
    //     $token_pagseguro = env('TOKEN_PAGSEGURO');
    //     $url_notificacao = env('URL_NOTIFICACAO');
    //     $email_loja = env('EMAIL_LOJA');
    //     $moeda_pagamento = env('MOEDA_PAGAMENTO');
    //     $billingAddressCountry = env('BILLINGADDRESSCOUNTRY');


    //     $dados_pagseguro = [

    //         'email' => $email_pagseguro,
    //         'token' => $token_pagseguro,
    //         'receiverEmail' => $email_loja,
    //         'notificationURL' => $url_notificacao,
    //         'billingAddressCountry' => $billingAddressCountry,
    //         "paymentMode" => "default",
    //         "paymentMethod" => "boleto",

    //         'senderHash' => $request->hashBoleto, //hash gerado pelo pagseguro
    //         'installmentValue' => strval($request->valorParcela), //valor da parcela
    //         'extraAmount' => number_format(0, 2, '.', ''),  

    //         'shippingAddressRequired' => False,
    //         'currency' => $moeda_pagamento,
    //         'itemId1' => $venda_item->id,
    //         'itemDescription1' => $produto->nome,
    //         'itemAmount1' => number_format($produto->valor, 2, '.', ''),
    //         'itemQuantity1' => 1,
    //         'reference' => $venda->id,
    //         'senderName' => $user->name,
    //         'senderCPF' => $cpf,
    //         'senderAreaCode' => $ddd,
    //         'senderPhone' => $celular,
    //         'senderEmail' => $user->email,
    //     ];

    //     $buildQuery = http_build_query($dados_pagseguro);
    //     $url = env('URL_PAGSEGURO') . "transactions";
    
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
    //     curl_setopt($curl, CURLOPT_POST, true);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
    //     $retornoxml = curl_exec($curl);
    //     curl_close($curl);      
    //     $response = simplexml_load_string($retornoxml);

    //     Log::info('Pagamento anuidade boleto | Pagamento efetuado'. json_encode($response));

    //     $codigo_venda = intval($response->reference);
    //     $codigo_tipo_pagto = intval($response->paymentMethod->type);
    //     $codigo_tipo_pagto_detalhe = $response->paymentMethod->code;
    //     $transacao = $response->code;
    //     $valor_venda = floatval($produto->valor);
    //     $parcelas = intval($request->parcelas);
    //     $valor_parcela = floatval($request->valorParcela);
    //     $valor_total = floatval($parcelas * $valor_parcela);
    //     $valor_juros = floatval($valor_total - $valor_venda);
    //     $valor_receber = floatval($response->netAmount);
    //     $codigo_status = intval($response->status);

    //     if(!$response->error){
     
    //         $pagamento = PagSeguroPgto::create([
    //             'tipo_pgto_detalhe' => $codigo_tipo_pagto_detalhe,
    //             'transacao' => $transacao,
    //             'parcelas' => $parcelas,
    //             'valor_parcela' => $valor_parcela,
    //             'valor_total' => $valor_total,
    //             'valor_juros' => $valor_juros,
    //             'valor_receber' => $valor_receber,
    //             'venda_id' => $codigo_venda,
    //             'tipo_pagto_id' => $codigo_tipo_pagto,
    //             'status_id' => $codigo_status,
    //             'user_id' => $user['id'],
    //         ]);
            
            
    //         Log::info('Pagamento boleto | Pagamento efetuado com sucesso'. json_encode($pagamento));
            
    //         return response()->json(['message' => 'success', 'response' => $response], 201);
    //     }

    //     Log::info('Pagamento boleto | Erro ao efetuar pagamento'. json_encode($response));
    //     return response()->json(['message' => 'error', 'response' => $response], 201);

    // }

    // public function nacionalcredito(Request $request)
    // { 

    //     $post = $request->all();
    //     unset($post['password']);
    //     unset($post['numCartao']);
    //     unset($post['cvv']);
    //     unset($post['validade']);
        
    //     $user = User::select('id', 'name', 'cpf', 'celular', 'email')
    //                 ->with('enderecos', 'enderecos.municipio', 'enderecos.municipio.estado')
    //                     ->find($post['id']);


    //     $produto = Produto::findOrFail($post['produto']);
    //     $endereco = $user->enderecos[0];
    //     $municipio = $user->enderecos[0]->municipio;
    //     $estado = $user->enderecos[0]->municipio->estado;

    //     $venda = Venda::create(['user_id' => $user['id']]);
    //     Log::info('Pagamento Nacional '.date('Y').' | Venda efetuada  com sucesso'. json_encode($venda));

    //     $venda_item = VendaItem::create([
    //         'venda_id' => $venda->id, 
    //         'produto_id' => $produto->id, 
    //         'qtd' => $post['parcelas'] ?? 1, 
    //         'valor' => $produto->valor, 
    //         'valor_total' => $produto->valor
    //     ]);
    //     Log::info('Pagamento Nacional '.date('Y').' | Venda de  item efetuado com sucesso'. json_encode($venda_item));

    //     //Formatação de dados para o PagSeguro
    //     $cpf = str_replace(['.', '-'], '', $user->cpf);
    //     $cep = str_replace('.', '-', $endereco->cep);
    //     $celular_str = str_replace(['(', ')',' ','-'], '', $user->celular);

    //     $ddd = substr($celular_str, 0, 2);
    //     $celular = substr($celular_str, 2, 9);

    //     $email_pagseguro = env('EMAIL_PAGSEGURO');
    //     $token_pagseguro = env('TOKEN_PAGSEGURO');
    //     $url_notificacao = env('URL_NOTIFICACAO');

    //     $dados_pagseguro = [

    //         'email' => $email_pagseguro,
    //         'token' => $token_pagseguro,
    //         'receiverEmail' => $email_pagseguro,
    //         'notificationURL' => $url_notificacao,
    //         'billingAddressCountry' => 'Brasil',
    //         "paymentMode" => "default",
    //         "paymentMethod" => "creditCard",
    //         //fazer chamada para o metodo de pagamento
    //         "creditCardToken" => $request->tokenCartao, //token do cartao
    //         'senderHash' => $request->hashCartao, //hash gerado pelo pagseguro
    //         'installmentQuantity' => $request->parcelas, //quantidade de parcelas
    //         'installmentValue' => strval($request->valorParcela), //valor da parcela
    //         'extraAmount' => number_format(0, 2, '.', ''),    
    //         'creditCardHolderName' => $user->name ,
    //         'creditCardHolderCPF' => $cpf,
    //         'creditCardHolderBirthDate' => '01/01/2000',
    //         // 'creditCardHolderBirthDate' => $user->data_nascimento ?? '01/01/2000',
    //         'creditCardHolderAreaCode' => $ddd,
    //         'creditCardHolderPhone' => $celular,
    //         'billingAddressStreet' => $endereco->logradouro,
    //         'billingAddressNumber' => $endereco->numero,
    //         'billingAddressComplement' => "",
    //         'billingAddressDistrict' => $endereco->bairro,
    //         'billingAddressPostalCode' => $cep,
    //         'billingAddressCity' => $municipio['nome'],
    //         'billingAddressState' => $estado['sigla'],
    //         'shippingAddressRequired' => False,
    //         'currency' => 'BRL',
    //         'itemId1' => $venda_item->id,
    //         'itemDescription1' => $produto->categoria. ' - ' .$produto->nome,
    //         'itemAmount1' => number_format($produto->valor, 2, '.', ''),
    //         'itemQuantity1' => 1,
    //         'reference' => $venda->id,
    //         'senderName' => $user->name,
    //         'senderCPF' => $cpf,
    //         'senderAreaCode' => $ddd,
    //         'senderPhone' => $celular,
    //         'senderEmail' => $user->email,
    //     ];

    //     Log::info('Pagamento Nacional '.date('Y').'  | Dados para pagamento enviados ao PagSeguro'. json_encode($dados_pagseguro));

    //     $buildQuery = http_build_query($dados_pagseguro);
    //     $url = env('URL_PAGSEGURO') . "transactions";
    
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
    //     curl_setopt($curl, CURLOPT_POST, true);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
    //     $retornoxml = curl_exec($curl);
    //     curl_close($curl);      
    //     $response = simplexml_load_string($retornoxml);

    //     Log::info('Pagamento Nacional '.date('Y').'  | Pagamento efetuado'. json_encode($response));

    //     $codigo_venda = intval($response->reference);
    //     $codigo_tipo_pagto = intval($response->paymentMethod->type);
    //     $codigo_tipo_pagto_detalhe = $response->paymentMethod->code;
    //     $transacao = $response->code;
    //     $valor_venda = floatval($produto->valor);
    //     $parcelas = intval($request->parcelas);
    //     $valor_parcela = floatval($request->valorParcela);
    //     $valor_total = floatval($parcelas * $valor_parcela);
    //     $valor_juros = floatval($valor_total - $valor_venda);
    //     $valor_receber = floatval($response->netAmount);
    //     $codigo_status = intval($response->status);

    //     if(!$response->error){
     
    //         $pagamento = PagSeguroPgto::create([
    //             'tipo_pgto_detalhe' => $codigo_tipo_pagto_detalhe,
    //             'transacao' => $transacao,
    //             'parcelas' => $parcelas,
    //             'valor_parcela' => $valor_parcela,
    //             'valor_total' => $valor_total,
    //             'valor_juros' => $valor_juros,
    //             'valor_receber' => $valor_receber,
    //             'venda_id' => $codigo_venda,
    //             'tipo_pagto_id' => $codigo_tipo_pagto,
    //             'status_id' => $codigo_status,
    //             'user_id' => $user['id'],
    //         ]);
                        
    //         Log::info('Pagamento Nacional '.date('Y').'  | Pagamento efetuado com sucesso'. json_encode($pagamento));

    //         return response()->json(['message' => 'success', 'response' => $user], 201);
    //     }

    //     Log::info('Pagamento Nacional '.date('Y').'  | Erro ao efetuar pagamento'. json_encode($response));
    //     return response()->json(['message' => 'error', 'response' => $response], 201);

    // }

    // public function nacionalboleto(Request $request)
    // {
    //     $post = $request->all();
    //     unset($post['password']);
    //     unset($post['numCartao']);
    //     unset($post['cvv']);
    //     unset($post['validade']);
    
    //     $user = User::select('id', 'name', 'cpf', 'celular', 'email')
    //                 ->with('enderecos', 'enderecos.municipio', 'enderecos.municipio.estado')
    //                     ->find($post['id']);


    //     $produto = Produto::findOrFail($post['produto']['id']);
    //     $endereco = $user->enderecos[0];
    //     $municipio = $user->enderecos[0]->municipio;
    //     $estado = $user->enderecos[0]->municipio->estado;
    
    //     $venda = Venda::create(['user_id' => $user['id']]);
    //     Log::info('Pagamento Nacional boleto | Venda efetuada  com sucesso'. json_encode($venda));

    //     $venda_item = VendaItem::create([
    //         'venda_id' => $venda->id, 
    //         'produto_id' => $produto->id, 
    //         'qtd' => $post['parcelas'] ?? 1, 
    //         'valor' => $produto->valor, 
    //         'valor_total' => $produto->valor
    //     ]);
    //     Log::info('Pagamento Nacional '.date('Y').' | Venda de  item efetuado com sucesso'. json_encode($venda_item));

    //     //Formatação de dados para o PagSeguro
    //     $cpf = str_replace(['.', '-'], '', $user->cpf);
    //     $cep = str_replace('.', '-', $endereco->cep);
    //     $celular_str = str_replace(['(', ')',' ','-'], '', $user->celular);

    //     $ddd = substr($celular_str, 0, 2);
    //     $celular = substr($celular_str, 2, 9);

    //     $email_pagseguro = env('EMAIL_PAGSEGURO');
    //     $token_pagseguro = env('TOKEN_PAGSEGURO');
    //     $url_notificacao = env('URL_NOTIFICACAO');
    //     $email_loja = env('EMAIL_LOJA');
    //     $moeda_pagamento = env('MOEDA_PAGAMENTO');
    //     $billingAddressCountry = env('BILLINGADDRESSCOUNTRY');

    //     $dados_pagseguro = [

    //         'email' => $email_pagseguro,
    //         'token' => $token_pagseguro,
    //         'receiverEmail' => $email_loja,
    //         'notificationURL' => $url_notificacao,
    //         'billingAddressCountry' => $billingAddressCountry,
    //         "paymentMode" => "default",
    //         "paymentMethod" => "boleto",

    //         'senderHash' => $request->hashBoleto, //hash gerado pelo pagseguro
    //         'installmentValue' => strval($request->valorParcela), //valor da parcela
    //         'extraAmount' => number_format(0, 2, '.', ''),  

    //         'shippingAddressRequired' => False,
    //         'currency' => $moeda_pagamento,
    //         'itemId1' => $venda_item->id,
    //         'itemDescription1' => $produto->nome,
    //         'itemAmount1' => number_format($produto->valor, 2, '.', ''),
    //         'itemQuantity1' => 1,
    //         'reference' => $venda->id,
    //         'senderName' => $user->name,
    //         'senderCPF' => $cpf,
    //         'senderAreaCode' => $ddd,
    //         'senderPhone' => $celular,
    //         'senderEmail' => $user->email,
    //     ];

    //     $buildQuery = http_build_query($dados_pagseguro);
    //     $url = env('URL_PAGSEGURO') . "transactions";
    
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
    //     curl_setopt($curl, CURLOPT_POST, true);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
    //     $retornoxml = curl_exec($curl);
    //     curl_close($curl);      
    //     $response = simplexml_load_string($retornoxml);

    //     Log::info('Pagamento Nacional | Pagamento efetuado'. json_encode($response));

    //     $codigo_venda = intval($response->reference);
    //     $codigo_tipo_pagto = intval($response->paymentMethod->type);
    //     $codigo_tipo_pagto_detalhe = $response->paymentMethod->code;
    //     $transacao = $response->code;
    //     $valor_venda = floatval($produto->valor);
    //     $parcelas = intval($request->parcelas);
    //     $valor_parcela = floatval($request->valorParcela);
    //     $valor_total = floatval($parcelas * $valor_parcela);
    //     $valor_juros = floatval($valor_total - $valor_venda);
    //     $valor_receber = floatval($response->netAmount);
    //     $codigo_status = intval($response->status);

    //     if(!$response->error){
     
    //         $pagamento = PagSeguroPgto::create([
    //             'tipo_pgto_detalhe' => $codigo_tipo_pagto_detalhe,
    //             'transacao' => $transacao,
    //             'parcelas' => $parcelas,
    //             'valor_parcela' => $valor_parcela,
    //             'valor_total' => $valor_total,
    //             'valor_juros' => $valor_juros,
    //             'valor_receber' => $valor_receber,
    //             'venda_id' => $codigo_venda,
    //             'tipo_pagto_id' => $codigo_tipo_pagto,
    //             'status_id' => $codigo_status,
    //             'user_id' => $user['id'],
    //         ]);
            
            
    //         Log::info('Pagamento Nacional boleto | Pagamento efetuado com sucesso'. json_encode($pagamento));
            
    //         return response()->json(['message' => 'success', 'response' => $response], 201);
    //     }

    //     Log::info('Pagamento Nacional boleto | Erro ao efetuar pagamento'. json_encode($response));
    //     return response()->json(['message' => 'error', 'response' => $response], 201);

    // }

    // public function retorno(Request $request)
    // {
    //     header( "access-control-allow-origin: https://pagseguro.uol.com.br");
    //     header( "Access-Control-Allow-Headers:*");
    //     header( "Access-Control-Allow-Method:*");

    //     if (!isset($request->notificationCode) || $request->notificationType != 'transaction') {

    //         Log::info('RETORNO | Erro ao receber retorno do pagseguro'. json_encode($request->all()));
    //         $msg = "notificationCode ou notificationType não possuem valor";
    //         exit;
    //     }

    //     Log::info('RETORNO | request'. json_encode($request->all()));
    
    //     $notificationCode = preg_replace('/[^[:alnum:]-]/','',$request->notificationCode);	
    //     $url = env('RETORNO_PAGSEGURO').$notificationCode.'?email='.env('EMAIL_PAGSEGURO').'&token='.env('TOKEN_PAGSEGURO');

    //     Log::info('RETORNO | URL de retorno do pagseguro'. json_encode($url));
        
    //     $curl = curl_init($url);	
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);	
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);	
    //     $xml= curl_exec($curl);	
    //     curl_close($curl);
    
    //     if($xml == 'Unauthorized'){

    //         Log::info('RETORNO | Unauthorized');

    //         exit;	
    //     }
    
    //     $xml = simplexml_load_string($xml);
    //     $transaction = $xml->code;
    //     $codigovenda = $xml->reference;
    //     $codigostatus = $xml->status;
    //     $xml->paymentMethod->code;
        
    //     if ($codigovenda && $codigostatus) {		
            
    //         $pagamento = PagSeguroPgto::select('id')->whereVendaId($codigovenda)->whereTransacao($transaction)->whereStatusId($codigostatus)->first();

    //         if(empty($pagamento)){

    //             $pagamento = PagSeguroPgto::select('id')->whereVendaId($codigovenda)->whereTransacao($transaction)->first();
    //             $pagamento->update([
    //                 'status_id' => $codigostatus,
    //             ]);
        
    //             Log::info('RETORNO | Pagamento atualizado com sucesso'. json_encode($pagamento));

    //         }else{
    //             Log::info('RETORNO | Pagamento já atualizado'. json_encode($pagamento));
    //         }
    //     } else {
    //         Log::info('RETORNO | Erro ao atualizar pagamento'. json_encode($xml));
    //     }  
    //     return response()->json($xml, 200);
    // }
