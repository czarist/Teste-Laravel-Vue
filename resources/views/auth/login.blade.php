<?php
    $status = $_GET['status'] ?? 0;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Intercom</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/structure.css" rel="stylesheet" type="text/css" class="structure" />
    <link href="assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
</head>

<body class="form">
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">                
                    <div class="form-content">
                        <?php
                        $div_status = "<div class='col-12 alert alert-success text-center mt-3 mb-3' role='alert'>
                            <h4 class='alert-heading'>Parabéns!</h4>
                            <p><b>Seu cadastro foi feito  com sucesso</b></p>
                            Você foi direcionado para a página de login.<br/>
                            Caso não tenha recebido o email contendo login e senha, verifique sua caixa de spam.
                        </div>";

                        $div_status2 = "<div class='col-12 alert alert-success text-center' role='alert'>
                                <h4 class='alert-heading'>Parabéns!</h4>
                                <p><b>Seu pagamento está em processamento, acompanhe pela área de pedidos</b></p>
                                Você foi direcionado para a página de login.<br/>
                                Caso não tenha recebido o email contendo login e senha, verifique sua caixa de spam.
                            </div>";

                    
                        if($status == 1){
                            echo $div_status;
                        }
                        if($status == 2){
                            echo $div_status2;
                        }

                    ?>
                        <h2 class="">Login Intercom</h2>

                        <form class="text-left" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form">

                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="cpf" type="text" placeholder="CPF" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" required autocomplete="cpf" autofocus pattern="^[0-9][0-9][0-9][.][0-9][0-9][0-9][.][0-9][0-9][0-9][-][0-9][0-9]$">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="password" placeholder="Senha" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Exibir Senha</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Entrar</button>
                                    </div>
                                </div>

                                <div class="field-wrapper">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="forgot-pass-link">Recuperar a senha?</a>
                                    @endif
                                </div>

                            </div>
                        </form>
                        <div class="d-sm-flex justify-content-center mt-5">
                            <div class="field-wrapper">
                                <a type="button" class="btn btn-primary" href="{{ route('cadastro')}}">Cadastre-se</a>
                            </div>
                        </div>

                        <p class="terms-conditions">© {{ date('Y') }} Intercom. </p>

                    </div>
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image">
            </div>
        </div>
    </div>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
	<script src="assets/js/jquery.mask.min.js"></script>
    <script src="assets/js/maskara.js"></script>

    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/authentication/form-1.js"></script>

</body>

</html>