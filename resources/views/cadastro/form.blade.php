@extends('layouts.app_no_navbar')

@section('content')

    {{-- <style>
        .card {
            width: 100% !important;
        }

        body {
            margin: 0 !important;
            letter-spacing: 0 !important;
            padding: 0 !important;

        }



        @media only screen and (max-width: 600px) {
            #cadastrohome {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }

        #cadastrohome {
            margin-left: 15%;
            margin-right: 15%;
        }

    </style> --}}


    {{-- <div class="col-12 mt-5">
        <div class="container">
            <div class="section-head style-3 text-center z mb-3">
                <img src="{{ asset('images/logo-principal.png') }}" />
            </div>
        </div>

        <div class="row" id="cadastrohome">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="card">
                    <h2 class="card-header title text-center">Sistema Unificado Intercom</h5>
                        <div class="card-body">
                            <form action="" method="post" id='foruser' name="foruser" accept-charset="utf-8">
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Nome</label>
                                        <input type="text" class="form-control" id="nome" placeholder="Digite seu nome"
                                            name="nome">
                                        <div class="valid-feedback">
                                            Correto!
                                        </div>
                                        <div class="invalid-feedback">
                                            Preencha seu nome!
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Email</label>
                                        <input type="email" class="form-control" id="inputEmail4"
                                            placeholder="Digite seu Email" name="email">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Senha</label>
                                        <input type="password" class="form-control" id="inputPassword4"
                                            placeholder="Senha" name="senha">
                                    </div>
                                </div>
                                <div class="form-row mb-4">

                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Estrangeiro</label><br>
                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="estrangeiro" id="option1"
                                                autocomplete="off" checked />
                                            <label class="btn btn-outline-primary" for="option1">Não</label>

                                            <input type="radio" class="btn-check" name="estrangeiro" id="option2"
                                                autocomplete="off" />
                                            <label class="btn btn-outline-primary" for="option2">Sim</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="cpf">CPF</label>
                                        <input type="text" class="form-control" id="cpf" placeholder="Digite seu CPF"
                                            name="cpf">
                                        <input type="hidden" name="passaporte" value="1">
                                    </div>
                                </div>
                                <input type="hidden" name="acao" value="incluir">

                                <button type="submit" class="btn btn-primary mt-3">Cadastrar</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div> --}}

    <form-cadastro>

@endsection
