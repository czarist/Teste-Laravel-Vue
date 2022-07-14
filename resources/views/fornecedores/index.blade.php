@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Listagem Fornecedores</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('fornecedores.create') }}"> Cadastrar Novo Fornecedor</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th></th>
            <th>Razão Social</th>
            <th>Nome Fantasia</th>
            <th>CNPJ</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Dados Bancarios</th>
            <th>Estado</th>
            <th>Bairro</th>
            <th>EndereÇo</th>
            <th>CEP</th>
            <th>Observações</th>

            <th width="280px"></th>
        </tr>

        @foreach ($fornecedores as $fornecedor)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $fornecedor->razao_social }}</td>
                <td>{{ $fornecedor->nome_fantasia }}</td>
                <td>{{ $fornecedor->cnpj }}</td>
                <td>{{ $fornecedor->email }}</td>
                <td>{{ $fornecedor->telefone }}</td>
                <td>{{ $fornecedor->dados_bancarios }}</td>
                <td>{{ $fornecedor->estado }}</td>
                <td>{{ $fornecedor->bairro }}</td>
                <td>{{ $fornecedor->endereco }}</td>
                <td>{{ $fornecedor->CEP }}</td>
                <td>{{ $fornecedor->detail }}</td>

                <td>
                    <form action="{{ route('fornecedores.destroy', $fornecedor->id) }}" method="POST">

                        <a class="btn btn-primary" href="{{ route('fornecedores.edit', $fornecedor->id) }}">Editar</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $fornecedores->links() !!}
@endsection
