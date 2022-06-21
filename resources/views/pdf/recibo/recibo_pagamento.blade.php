<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sistema Unificado Intercom</title>
    <style>

        html{
            margin:0;
            padding:0
        }

        body{
            font-family: 'DejaVu Sans' !important;
            background: #f5f9fb;
        }

        .main{
            width: 850px;
            /* height: 700px; */
            text-align: center;
            padding-left: 120px;
            padding-top: 230px;
        }

        p{
            font-family: 'DejaVu Sans' !important;
        }

        b{
            font-family: 'DejaVu Sans' !important;
        }

        .footer{
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: center;
        }

    </style>
</head>
<body style="margin: 0">
    <div style="main">
        <div style="background: #38acbc; text-align-last: center; padding-top: 10px; padding-bottom: 10px; margin: 0; color: #FFF" align="center">
            <img src="https://www.sistemas.intercom.org.br/images/logo-recbibo.png">
        </div>
        <div style="background: #f5f9fb; color: 5F5C5C; padding: 30px; font-size: 14px; font-family: DejaVu Sans; line-height: 24px;">
            <div align="center" style="text-align: justify !important;">
                <div style="text-align: center !important;"><strong>{{ $recibo['numero_congresso'] }}</strong></div> <br><br><br>
                <div>
                    <div>
                        <p><strong style="font-family: 'DejaVu Sans' !important;">Inscrição:</strong> {{ $recibo['inscricao'] }}</p>
                        <p><strong style="font-family: 'DejaVu Sans' !important;">Recibo Nº</strong> {{ $recibo['recibo'] }}</p>
                        <br><br>
                    </div> 
                    <div>
                        Recebemos de <strong>{{ $recibo['nome'] }}</strong> CPF/CNPJ: <strong>{{ $recibo['cpf'] }}</strong> a importância de <strong>R${{ $recibo['valor'] }}</strong>, referente ao pagamento da taxa de
                        inscrição no <strong>{{ $recibo['numero_congresso']}}</strong>, a ocorrer de forma virtual, de <strong>{{ $recibo['data_congresso'] }}</strong>. <br>
                        Data do Recibo : <strong>{{ $recibo['data_pagamento']}}</strong><br>
                        Forma de Pagto: <strong>{{ $recibo['tipo_pagamento']}}</strong><br>
                        Número de Autenticação: <strong>{{ $recibo['autenticacao']}}</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <div align="center" style="background: #38acbc; color: #FFF; font-size: 11px; font-family: DejaVu Sans; line-height: 20px;">
            <strong>
                Sociedade Brasileira de Estudos Interdisciplinares da Comunicação - INTERCOM 
                CNPJ: 51.201.093/0001-53 <br>
                Avenida Brigadeiro Luís Antonio, 2050 – Conj. 36 – Bela Vista - CEP: 01318-912 - São Paulo – SP
                Telefone: 11 3892-7557<
                E-mail: secretaria@intercom.org.br | secretaria.intercom@gmail.com
                Web: www.portalintercom.org.br
                <br>
            </strong>
        </div>
    </div>
</body>
</html>