<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema Unificado Intercom</title>
<style>

    p{
        font-family: 'DejaVu Sans' !important;
    }

    b{
        font-family: 'DejaVu Sans' !important;
    }

    body{
        font-family: 'DejaVu Sans' !important;
    }

</style>
</head>
<body style="margin: 0">
    <div id="mensagem" style="border: solid #3A48E5 1px">
        <div id="top" style="background:#285aa7; text-align-last: center; padding-top: 10px; padding-bottom: 10px; margin: 0; color: #FFF" align="center">
            Sistema Unificado Intercom
        </div>
        {{-- <div id="cabecalho" style="background: #fff; height: auto; padding-bottom: 20px; padding-top: 20px; margin: 0" align="center">
            <img src="https://portalintercom.org.br/assets/images/logo-principal.png">
        </div> --}}
        <div id="corpo" style="background: #f5f9fb; color: 5F5C5C; padding: 30px; font-size: 14px; font-family: DejaVu Sans; line-height: 24px;">
            <div align="center" style="border: black; border-style: solid;">
                <div><b>Resultado da avaliação do Trabalho</strong></div>
                <div style="border: black; border-style: solid;">
                    <div>
                        <p><strong style="font-family: 'DejaVu Sans' !important;">Título</strong> {{ $trabalho['titulo'] }}</p>
                        <p><strong style="font-family: 'DejaVu Sans' !important;">Autores</strong> {{ $trabalho['autor'] }}</p>
                        @if ($trabalho['coautores'])
                        <p><strong style="font-family: 'DejaVu Sans' !important;">Coautores</strong>
                            @foreach ($trabalho['coautores'] as $coautor)
                                    {{ $coautor }},                                                                
                            @endforeach
                        </p> 
                        @endif
                        <p><strong style="font-family: 'DejaVu Sans' !important;">Evento</strong> Congresso regional {{ $trabalho['regiao'] }}</p>
                        <p><strong style="font-family: 'DejaVu Sans' !important;">Data</strong> {{ $trabalho['data'] }}</p>
                    </div> 
                </div>
            </div>
            <br>
            <div>
            <div style="text-align: justify !important;">
                Temos a satisfação de informar que o trabalho acima indicado, proposto para apresentação oral no Congresso Regional
                {{ $trabalho['regiao'] }} foi <strong style="font-family: 'DejaVu Sans' !important;">ACEITO</strong>.<br>
                Em breve, divulgaremos em www.intercom.org.br a programação completa do Congresso, na qual você poderá conferir
                a data e horário da sessão em que deverá apresentar seu trabalho, bem como a lista de trabalhos aceitos. Conheça-os
                com antecedência para melhor participar dos debates durante o evento. Estamos providenciando recursos multimídia
                para a apresentação dos trabalhos, mas recomendamos que você prepare uma versão alternativa de sua exposição,
                que não dependa de equipamentos, para a eventualidade de não haver tais recursos na sala onde ela ocorrer. Caso
                você tenha dúvidas a este respeito, contate o coordenador de seu GT. Nós o agradecemos desde já por sua presença e
                contribuição acadêmica ao Congresso.  
            </div><br>  
            <div align="center">
                Cordialmente,<br>
                <strong style="font-family: 'DejaVu Sans' !important;">Intercom - Sociedade Brasileira de Estudos Interdisciplinares da Comunicação</strong>
            </div>
        </div>
    </div>
</body>
</html>