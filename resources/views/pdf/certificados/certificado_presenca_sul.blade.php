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
        width: 950px;
        /* height: 700px; */
        text-align: center;
        padding-left: 90px;
        padding-top: 220px;
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
        <div align="center" style="">participou do XXI Congresso de Ciências da Comunicação na Região {{$certificado['regiao']}}, promovido pela Sociedade Brasileira de Estudos Interdisciplinares da Comunicação - INTERCOM e realizado pela Univali - Universidade do Vale do Itajaí, entre os dias 16 a 18 de junho, na Cidade de Balneário Camboriú/SC, como
    CONGRESSISTA.</div>
    <br>
    Carga horária: 30 horas.
    </div>

</body>
</html>