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

        Você foi selecionado como avaliador de trabalho(s) do Expocom. Para ter acesso aos trabalhos, acesse sua área de avaliador em sistemas.intercom.org.br. Todas as orientações estão no chat, junto ao(s) trabalho(s) designados.

        </div>
        <div id="kirc" style="background: #f5f9fb; color: 5F5C5C; padding: 30px; font-size: 14px; font-family: Arial; line-height: 24px; text-align: center" align="center">
            Um sistema desenvolvido por <a href="http://kirc.com.br"><img src="{{ asset('images/logo-email.png') }}"></a>
            <a href="http://kirc.com.br">http://kirc.com.br</a>
        </div>
    </div>
</body>
</html>