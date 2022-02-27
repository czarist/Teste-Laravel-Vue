@extends('layouts.app')

@section('content')

<associado-area :user="{{ $user }}"></associado-area>



{{-- <table class="table">
    <thead>
      <tr>
        <th scope="col">NOME</th>
        <th scope="col">CPF</th>
        <th scope="col">VALOR</th>
        <th scope="col">AÇÃO</th>
      </tr>
    </thead>
    <tbody>
        @if (!Auth::user()->is_associado)            
            <tr>
                <th>{{ Auth::user()->name }}</th>
                <td>{{ Auth::user()->cpf }}</td>
                <td>R$200,00</td>
                <td>
                    @if (!Auth::user()->is_associado)
                        <form class="ml-3">
                            <a class="btn btn-outline-alert" href="{{ route('filiese')}}">FILIAR-SE</a>
                        </form>    
                    @endif
    
                </td>
            </tr>
        @endif
      <tr>
        @if (Auth::user()->is_associado)            
            <tr>
                <th>{{ Auth::user()->name }}</th>
                <td>{{ Auth::user()->cpf }}</td>
                <td>R$230,00</td>
                <td>
                    @if (Auth::user()->is_associado)
                        <form class="ml-3">
                            <a class="btn btn-outline-alert" href="{{ route('associado')}}">PAGAR ANUIDADE 2022</a>
                        </form>    
                    @endif
    
                </td>
            </tr>
        @endif
      </tr>
    </tbody>
  </table>
   --}}

@endsection
    