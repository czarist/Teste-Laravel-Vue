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
        <div align="center" style="">Certificamos que</div>
        <div align="center" style="font-size: 30px; padding-top: 20px; padding-bottom: 20px; ">{{  $certificado['user']['name'] }}</div>

        <div align="center" style="">participou do XIX Congresso de Ciências da Comunicação na Região {{$certificado['regiao']}}, promovido pela Sociedade Brasileira de Estudos Interdisciplinares da Comunicação - INTERCOM 
            e realizado pela UFT - Universidade Federal do Tocantins, entre os dias de 2 a 4 de junho, na Cidade de Palmas/TO, como
            PARECERISTA do(a)
            @if (isset($certificado['tipo']) && count($certificado['tipo']))             
                @foreach ($certificado['tipo'] as $tipo)
                    @if($loop->last)
                        {{ $tipo }} - 
                    @else
                        {{ $tipo }},
                    @endif
                @endforeach
            @endif
            @if (isset($certificado['categoria']) && count($certificado['categoria']))             
                @foreach ($certificado['categoria'] as $categoria)
                    @if($loop->last)
                        {{ $categoria }}.
                    @else
                        {{ $categoria }},
                    @endif
                @endforeach
            @endif

        </div>

    </div>

</body>
</html>