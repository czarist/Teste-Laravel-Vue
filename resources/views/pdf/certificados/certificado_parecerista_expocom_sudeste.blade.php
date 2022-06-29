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
        background-size: cover;
        background-repeat: no-repeat;
    }

    .main{
        width: 850px;
        /* height: 700px; */
        text-align: center;
        padding-left: 170px;
        padding-top: 170px;
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

        <div align="center" style="">participou do XXV Congresso de Ciências da Comunicação na Região {{$certificado['regiao']}}, promovido pela Sociedade Brasileira de Estudos Interdisciplinares da Comunicação - INTERCOM e realizado pela PUC Minas (Pontifícia Universidade Católica de Minas Gerais), entre os dias 26 e 28 de maio, na Cidade de Poços de Caldas/MG, como
            PARECERISTA do PRÊMIO EXPOCOM – Exposição de Pesquisa e Produção Experimental em Comunicação, na Categoria 
            @if (isset($certificado['categoria']) && count($certificado['categoria']))             
                @foreach ($certificado['categoria'] as $categoria)
                    @if($loop->last)
                        {{ $categoria }}, Modalidade 
                    @else
                        {{ $categoria }},
                    @endif
                @endforeach
            @endif
            @if (isset($certificado['modalidade']) && count($certificado['modalidade']))             
                @foreach ($certificado['modalidade'] as $modalidade)
                    @if($loop->last)
                        {{ $modalidade }}.
                    @else
                        {{ $modalidade }},
                    @endif
                @endforeach
            @endif
        </div>
    </div>

</body>
</html>