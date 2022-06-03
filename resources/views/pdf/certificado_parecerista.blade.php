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
        background-size: contain;
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
</style>
</head>
<body style="margin: 0; {{$certificado['image']}}">
    <div class="main">
        <div align="center" style="font-weight: bold;">Certificamos que</div>
        <div align="center" style="font-size: 30px; padding-top: 20px; padding-bottom: 20px; ">{{  $certificado['user']['name'] }}</div>

        <div align="center" style="font-weight: bold;">participou do XXII Congresso de Ciências da Comunicação na Região {{$certificado['regiao']}}, promovido pela Sociedade Brasileira de Estudos Interdisciplinares da Comunicação - INTERCOM e realizado pela Universidade Católica de Salvador - UCSAL, entre os dias 18 e 20 de maio, na Cidade de Salvador/BA, como
            PARECERISTA do(a) {{$certificado['tipo']}} - {{$certificado['categoria']}}.
        </div>

    </div>

</body>
</html>