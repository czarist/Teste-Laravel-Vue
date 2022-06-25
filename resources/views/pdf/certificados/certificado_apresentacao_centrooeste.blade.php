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
        padding-left: 140px;
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

        @if (isset($certificado['coautores']) && count($certificado['coautores']) >= 5)
            <div align="center" style=" font-size: 10px;">
        @endif

        @if (isset($certificado['coautores']) && count($certificado['coautores']) < 5)
            <div align="center" style=" font-size: 15px;">
        @endif

            participou do XXII Congresso de Ciências da Comunicação na Região {{$certificado['regiao']}}, promovido pela Sociedade Brasileira de Estudos Interdisciplinares da 
            Comunicação - INTERCOM e realizado pela UFMT - Universidade Federal de Mato Grosso(evento integralmente online), entre os dias 9 a 11 de junho, na Cidade de Cuiabá e Barra do Garças/MT, como 
            Expositor(a) - Exposição de Pesquisa e Produção Experimental em Comunicação, na Região {{$certificado['regiao']}}, 
            com o trabalho "{{ $certificado['titulo']}}", no 
            {{ $certificado['tipo']}} - {{ $certificado['categoria']}}, 
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