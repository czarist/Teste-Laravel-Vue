<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Email Intercom</title>
</head>

<body style="margin: 0">

    <div id="mensagem" style="border: solid #3A48E5 1px">
        <div id="top" style="background:#285aa7; text-align-last: center; padding-top: 10px; padding-bottom: 10px; margin: 0; color: #FFF" align="center">
                {{ env('APP_NAME') }}
        </div>
        <div id="cabecalho" style="background: #fff; height: auto; padding-bottom: 20px; padding-top: 20px; margin: 0" align="center">
            <img src="{{ asset('https://portalintercom.org.br/assets/images/logo-principal.png') }}">
        </div>
        <div id="corpo" style="background: #f5f9fb; color: 5F5C5C; padding: 30px; font-size: 14px; font-family: Arial; line-height: 24px;">

			<p style="padding-left: 20px; padding-right: 20px; text-align: center;">
				Você foi cadastrado como coordenador
			</p>
            
			<p style="padding-left: 20px; padding-right: 20px; text-align: left;">

                Nome: {{ $name ?? "Sem informação"}} <br><br>
				CPF: {{ $cpf ?? "Sem informação" }} <br><br>
				Tipo: {{ $post['tipo'] ?? "Sem informação"  }} <br><br>
				Regiao: {{ $post['regiao'] ?? "Sem informação"  }} <br><br>
				Dt ou Ij: {{ $post['dt'] ?? "Sem informação"  }} <br><br>
				Ano: {{ $post['ano'] ?? "Sem informação"  }} <br><br>

                Link para acessar sua área restrita <a href="{{ env('APP_URL')}}">{{ env('APP_URL')}}</a>.
			</p>
            <br>
        </div>
        <div id="kirc" style="background: #f5f9fb; color: 5F5C5C; padding: 30px; font-size: 14px; font-family: Arial; line-height: 24px; text-align: center" align="center">
            Um sistema desenvolvido por <a href="http://kirc.com.br"><img src="{{ asset('images/logo-email.png') }}"></a>
            <a href="http://kirc.com.br">http://kirc.com.br</a>
        </div>
    </div>
</body>
</html>