<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\PagSeguroPgto;
use App\Models\Produto;
use App\Models\User;
use App\Models\Venda;
use App\Models\VendaItem;
use App\Services\Request as ServicesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PagSeguroController extends Controller
{
    public function pagamento()
    {
        //Verificar ambientes de produção ou desenvolvimento
        // if (App::environment('production')) {
        //     $url = env('URL_PAGSEGURO') . "sessions?email=" . env('EMAIL_PAGSEGURO') . "&token=" . env('TOKEN_PAGSEGURO');

        // }else {
        //     $url = env('SANDBOX_URL_PAGSEGURO') . "sessions?email=" . env('EMAIL_PAGSEGURO') . "&token=" . env('SANDBOX_TOKEN_PAGSEGURO');

        // }

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
        $senha = $request['password'];
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ativo' => 1,
            'sexo_id' => $request->sexo_id,
            'estrangeiro' => $request->estrangeiro,
            'passaporte' => $request->passaporte,
            'cpf' => $request->cpf,
            'rg' => $request->rg,
            'orgao_expedidor' => $request->orgao_expedidor,
            'telefone' => $request->telefone,
            'celular' => $request->celular,
            'data_nascimento' => $request->data_nascimento,                
        ]);
        
        $acessos =[0 => 4];
        $todos_tipos_id = [0 => 4];            
        $user->acessos()->sync($acessos);
        $user->todos_tipos()->sync($todos_tipos_id);

        if (!empty($request->enderecos)) {
            $endereco = Endereco::create(
                [
                    'user_id' => $user->id,
                    'logradouro' => $request['enderecos']['logradouro'],
                    'municipio_id' => $request['enderecos']['municipio']['id'] ?? 1,
                    'cep' => $request['enderecos']['cep'] ?? 00000-000,
                    'pais_id' => $request['enderecos']['pais'] ?? 'Brasil',
                ]
            );
        }
        Log::info('Cadastro de usuario: ' . json_encode($user));

        $data = ['user' => $user, 'senha' => $senha];
        Mail::send('cadastro.email', $data, function ($email) use ($user) {
            $email->subject('Cadastro de Usuário - INTERCON');
            if (App::environment('production')) {
                $email->to($user['email']);
            } else {
                $email->to('murilocarvalho2204@gmail.com');
            }
            Log::info('E-mail enviado apos o cadastro para :'. $user['nome'] .' com o email: '. json_encode($user['email']));
        });

        if(!empty($request->associado) && $request->associado == 1)
        {
            $produto = Produto::findOrFail(1);
        }
        $venda = Venda::create(['user_id' => $user['id']]);

        Log::info('Venda efetuada  com sucesso'. json_encode($venda));

        $venda_item = VendaItem::create(['venda_id' => $venda->id, 'produto_id' => $produto->id, 'qtd' => $request->quantidade ?? 1, 'valor' => $produto->valor, 'valor_total' => $produto->valor * $request->quantidade]);

        Log::info('Venda de  item efetuado com sucesso'. json_encode($venda_item));

        //Formatação de dados para o PagSeguro
        $cpf = str_replace('.', '-', $request->cpf);
        $cep = str_replace('.', '-', $request->enderecos['cep']);
        $ddd = substr($request->celular, 0, 2);
        $celular = substr($request->celular, 2, 9);


        //Verificar ambientes de produção ou desenvolvimento
        if (App::environment('production')) {

            $email_pagseguro = env('EMAIL_PAGSEGURO');
            $token_pagseguro = env('TOKEN_PAGSEGURO');
            $url_notificacao = env('URL_NOTIFICACAO');

        } else {

            $email_pagseguro = env('EMAIL_PAGSEGURO');
            $token_pagseguro = env('SANDBOX_TOKEN_PAGSEGURO');
            $url_notificacao = env('SANDBOX_URL_NOTIFICACAO');

        }

        // $reponse = ServicesRequest::sendRequest([

        //         //options
        //         'method' => $this->method,
        //         'url_base' => $this->url_base,
        //         'uri' => $this->uri,
        //     ], [
        //         //headers
        //     ],  [
        //         //body
                
        //     ],  [

        //     'email' => env('EMAIL_PAGSEGURO'),
        //     'token' => env('TOKEN_PAGSEGURO'),
        //     'receiverEmail' => env('EMAIL_PAGSEGURO'),
        //     'notificationURL' => env('URL_NOTIFICACAO'),
        //     'billingAddressCountry' => 'Brasil',
        //     "paymentMode" => "default",
        //     "paymentMethod" => "creditCard",
        //     //fazer chamada para o metodo de pagamento
        //     "creditCardToken" => $request->tokenCartao, //token do cartao
        //     'senderHash' => $request->hashCartao, //hash gerado pelo pagseguro
        //     'installmentQuantity' => $request->parcelas, //quantidade de parcelas
        //     'installmentValue' => strval($request->valorParcela), //valor da parcela
        //     'extraAmount' => number_format(0, 2, '.', ''),    
        //     'creditCardHolderName' => $request->name ,
        //     'creditCardHolderCPF' => $request->cpf,
        //     'creditCardHolderBirthDate' => $request->data_nascimento,
        //     'creditCardHolderAreaCode' => $ddd,
        //     'creditCardHolderPhone' => $celular,
        //     'billingAddressStreet' => $request['enderecos']['logradouro'],
        //     'billingAddressNumber' => "0",
        //     'billingAddressComplement' => "",
        //     'billingAddressDistrict' => $request['enderecos']['bairro'],
        //     'billingAddressPostalCode' => $request['enderecos']['cep'],
        //     'billingAddressCity' => $request['enderecos']['municipio']['nome'],
        //     'billingAddressState' => $request['enderecos']['estado']['sigla'],
        //     'shippingAddressRequired' => False,
        //     'currency' => 'BRL',
        //     'itemId1' => $venda_item->id,
        //     'itemDescription1' => $produto->nome,
        //     'itemAmount1' => $produto->valor,
        //     'itemQuantity1' => $request->quantidade,
        //     'reference' => $venda->id,
        //     'senderName' => $request->name,
        //     'senderAreaCode' => $ddd,
        //     'senderPhone' => $celular,
        //     'senderEmail' => $request->email,
        // ]);

        $pagamento = PagSeguroPgto::create([
            'tipo_pgto_detalhe' => 101,
            'transacao' => '2AD484A3-8830-4323-9F4A-3CA33A9D2F7C',
            'parcelas' => 1,
            'valor_parcela' => 200.00,
            'valor_total' => 200.00,
            'valor_juros' => 0.00,
            'valor_receber' => 165.00,
            'venda_id' => $venda->id,
            'tipo_pagto_id' => 1,
            'status_id' => 3,
            'user_id' => $user['id'],
        ]);

        Log::info('Pagamento efetuado com sucesso'. json_encode($pagamento));

        return response()->json(['message' => 'success', 'response' => $user], 201);
    }

}
