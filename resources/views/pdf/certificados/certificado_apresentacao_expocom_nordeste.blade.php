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

        @if (isset($certificado['coautores']) && count($certificado['coautores']) >= 5)
            <div align="center" style=" font-size: 10px;">
        @endif

        @if (isset($certificado['coautores']) && count($certificado['coautores']) < 5)
            <div align="center" style=" font-size: 15px;">
        @endif

            participou do XXII Congresso de Ciências da Comunicação na Região {{$certificado['regiao']}}, promovido pela Sociedade Brasileira de Estudos Interdisciplinares da 
            Comunicação - INTERCOM e realizado pela Universidade Católica de Salvador - UCSAL, entre os dias 18 e 20 de maio, na Cidade de Salvador/BA, como 
            Expositor(a) no PRÊMIO EXPOCOM - Exposição de Pesquisa e Produção Experimental em Comunicação, na Região {{$certificado['regiao']}}, 
            com o trabalho "{{ $certificado['titulo']}}", na 
            Categoria {{ $certificado['categoria']}}, 
            Modalidade {{ $certificado['modalidade']}}, 
            de autoria de
            @if (isset($certificado['coautores']) && count($certificado['coautores']))
                @foreach ($certificado['coautores'] as $coautor)
                    @if($loop->last)
                        {{ $coautor }}.
                    @else
                        {{ $coautor }},
                    @endif

                @endforeach
            @endif
        </div>
    </div>
</body>
</html>