<!doctype html>
<html>
<head>
<meta charset="utf-8">

</head>

<body>
	<div align="center">
		<div id="topo" style="background: #285aa7; min-height: 25px; position: relative; width: 650px; border: 0.5px #285aa7 solid; color: #fff; font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial, sans-serif; font-size: 13px; vertical-align: middle; padding-top: 8px; padding-bottom: 0px;">
			{{ env('APP_NAME') }}
		</div>
		<div id="header" style="margin: 0; width: 650px; background: #fff; height: 280px; border-left: #ccc 0.5px solid; border-right: #ccc solid 0.5px; ">
			<div align="center"><img src="{{ asset('images/logo-principal.png') }}" style="margin-top: 8px; width: 280px;"></div>
		
		</div>
		<div id="corpo" style="margin-top: -10px; width: 650px; background: #f5f9fb; border-left: #ccc 0.5px solid; border-right: #ccc solid 0.5px; font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial, sans-serif; font-size: 16px; color: #5F5C5C; border-bottom: 0.5px solid #ccc;">
			
			<p style="padding-left: 20px; padding-right: 20px; text-align: center;">
				Seu inscricão foi realizada com sucesso
			
			</p>

            <p style="padding-left: 20px; padding-right: 20px; text-align: center;">
				{{ $post['taxa_inscricao']['categoria'] ?? null }} <br><br>
			</p>
            
			<p style="padding-left: 20px; padding-right: 20px; text-align: left;">

                Nome: {{ $post['name'] ?? null}} <br><br>
				CPF: {{ $post['cpf'] }} <br><br>
				CATEGORIA: {{ $post['taxa_inscricao']['nome']  }} <br><br>
				VALOR: {{ $post['taxa_inscricao']['valor']  }} <br><br>

                Link para acessar sua área restrita <a href="{{ env('APP_URL')}}">{{ env('APP_URL')}}</a>.
			</p>
            <br><br>

            <p style="padding-left: 20px; padding-right: 20px; text-align: left"> Um sistema desenvolvido por
                <a href="http://kirc.com.br"><img src="{{ asset('images/logo-email.png') }}"></a>
            </p>
            <br>

		</div>	
	</div>
</body>
</html>
