@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="mt-4">
            <h5 class="col-12 d-flex justify-content-between">
                Relatório Regionais
            </h5> 

            <div class="col-12">
                @include('financeiro.relatorios.filtro')
            </div>
    
            <div class="col-12">
                <div class="card">
                    <div class="card-body pb-2">
                        <div class="table-responsive">
                            <table id="tableData" class="table table-striped table-bordered table-hover table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="font-size: 1em;" class="align-middle pl-2 text-center">NOME</th>
                                        <th scope="col" style="font-size: 1em;" class="align-middle pl-2 text-center">REGIÃO</th>
                                        <th scope="col" style="font-size: 1em;" class="align-middle pl-2 text-center">VLR BRUTO</th>
                                        <th scope="col" style="font-size: 1em;" class="align-middle pl-2 text-center">VLR LIQUIDO</th>
                                        <th scope="col" style="font-size: 1em;" class="align-middle pl-2 text-center">TAXAS</th>
                                        <th scope="col" style="font-size: 1em;" class="align-middle pl-2 text-center">TIPO</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach($users as $user)
                                        <tr>
                                            <td style="text-align: center;">{{ $user->name }}</td>
                                                @if ($tipo == 1)
                                                    @foreach ($user->todos_tipos_pagamentos as $tipo_pagamento)
                                                        @if ($tipo_pagamento->id == 1)
                                                            @foreach ($user->vendas as $venda)
                                                                @if (
                                                                    $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 1 && $venda->pagamento && $venda->pagamento->status_id == 3
                                                                ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 1 && $venda->pagamento && $venda->pagamento->status_id == 4
                                                                )
                                                                    <td style="text-align: center;">Teste</td>
                                                                    <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_total) ?? "0,00"}} </td>
                                                                    <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_receber) ?? "0,00"}} </td>
                                                                    @php
                                                                        $taxa = $venda->pagamento->valor_total - $venda->pagamento->valor_receber;
                                                                    @endphp
                                                                    <td style="text-align: center;">{{ str_replace('.', ',', $taxa) ?? "0,00" }}</td>
                                                                    <td style="text-align: center;">Pagou Teste</td>                                    
                                                                @endif
                                                            @endforeach
                                                        @elseif($tipo_pagamento->id == 2)
                                                            <td style="text-align: center;">Sul</td>
                                                            <td style="text-align: center;">0,00</td>
                                                            <td style="text-align: center;">0,00</td>
                                                            <td style="text-align: center;">0,00</td>
                                                            <td style="text-align: center;">Usuário Isento</td>
                                                        @elseif($tipo_pagamento->id == 3)
                                                            <td style="text-align: center;">Sul</td>
                                                            <td style="text-align: center;">0,00</td>
                                                            <td style="text-align: center;">0,00</td>
                                                            <td style="text-align: center;">0,00</td>
                                                            <td style="text-align: center;">Associado Isento</td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="excel-form" action="{{ route('financeiro.relatorios.excel') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="tipo" value="{{ $_GET['tipo'] ?? null }}">
    </form>

@endsection
