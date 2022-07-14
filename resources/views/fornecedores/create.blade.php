@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Cadastrar Novo Fornecedor</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('fornecedores.index') }}"> Voltar</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="app" action="{{ route('fornecedores.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>CNPJ:</strong>
                    <input required id="cnpj" type="text" name="cnpj" class="form-control"
                        v-mask='"##.##.###/####-## "' placeholder="CNPJ" maxlength="17">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Razão Social:</strong>
                    <input required type="text" name="razao_social" class="form-control" placeholder="Razão Social">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nome Fantasia:</strong>
                    <input required type="text" name="nome_fantasia" class="form-control" placeholder="Nome Fantasia">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>E-mail:</strong>
                    <input required type="email" name="email" class="form-control" placeholder="E-mail">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Telefone:</strong>
                    <input required type="telefone" name="telefone" class="form-control" placeholder="Telefone">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Dados Bancarios:</strong>
                    <input required type="text" name="dados_bancarios" class="form-control"
                        placeholder="Dados Bancarios">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Estado:</strong>
                    <input required type="text" name="estado" class="form-control" placeholder="Estado">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Cidade:</strong>
                    <input required type="text" name="cidade" class="form-control" placeholder="Cidade">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Bairro:</strong>
                    <input required type="text" name="bairro" class="form-control" placeholder="Bairro">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Endereço:</strong>
                    <input required type="text" name="endereco" class="form-control" placeholder="Endereço">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>CEP:</strong>
                    <input required type="text" name="CEP" class="form-control" placeholder="CEP">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Observações:</strong>
                    <textarea class="form-control" style="height:150px" name="detail" placeholder="Observações:"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">CADASTRAR</button>
            </div>
        </div>

    </form>

@endsection
