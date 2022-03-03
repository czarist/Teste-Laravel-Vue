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
		<div id="header" style="margin: 0; width: 650px; background: #fff; height: 150px; border-left: #ccc 0.5px solid; border-right: #ccc solid 0.5px; ">
			<div align="center"><img src="{{ asset('images/logo-principal.png') }}" style="margin-top: 8px; width: 280px;"></div>
		
		</div>
		<div id="corpo" style="margin-top: -10px; width: 650px; background: #f5f9fb; height: 300px; border-left: #ccc 0.5px solid; border-right: #ccc solid 0.5px; font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial, sans-serif; font-size: 16px; color: #5F5C5C; border-bottom: 0.5px solid #ccc;">
			
            <h1>Esqueci a senha do e-mail</h1>
   
            Você pode redefinir a senha no link abaixo:
            <a href="{{ route('reset.password.get', $token) }}">Redefinir senha</a>
                    </div>	
	</div>
</body>
</html>
