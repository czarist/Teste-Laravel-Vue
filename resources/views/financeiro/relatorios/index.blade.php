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
                                            <td class="align-middle pl-2">{{ $user->name }}</td>
                                            @if ($user && count($user->vendas) == 0)
                                                @foreach ($user->todos_tipos as $tipo )
                                                    @if ($tipo->id == 6)
                                                        <td style="text-align: center;">Sul</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">Usuário Isento</td>
                                                        @break
                                                    @elseif($tipo->id == 7)
                                                        <td style="text-align: center;">Nordeste</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">Usuário Isento</td>
                                                        @break
                                                    @elseif($tipo->id == 8)
                                                        <td style="text-align: center;">Sudeste</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">Usuário Isento</td>
                                                        @break
                                                    @elseif($tipo->id == 9)
                                                        <td style="text-align: center;">Centro Oeste</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">Usuário Isento</td>
                                                        @break
                                                    @elseif($tipo->id == 10)
                                                        <td style="text-align: center;">Norte</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">Usuário Isento</td>
                                                        @break
                            
                                                    @endif
                                                @endforeach
                                            @elseif($user && count($user->vendas) > 0)
                                                <td style="text-align: center;">
                                                    @if (!empty($user->regional_sul))
                                                        Sul
                                                    @elseif (!empty($user->regional_nordeste))
                                                        Nordeste
                                                    @elseif (!empty($user->regional_norte))
                                                        Norte
                                                    @elseif (!empty($user->regional_centrooeste))
                                                        Centro-Oeste
                                                    @elseif (!empty($user->regional_suldeste))
                                                        Sudeste
                                                    @else
                                                        Não fez inscrição
                                                    @endif
                                                </td>                        
                        
                                                @foreach($user->vendas as $venda)                        
                                                    @if(
                                                        $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 3
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 4
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 5
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 6                                                            
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 3
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 4
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 5
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 6       
                                                    )
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_total) }}</td>
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_receber) }}</td>
                                                        @php
                                                            $taxa = $venda->pagamento->valor_total - $venda->pagamento->valor_receber;
                                                        @endphp
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $taxa) }}</td>
                                                        <td style="text-align: center;">Pago Sul</td>
                                                        @break
                                                    @elseif (                                                                                                                    
                                                        $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 8
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 9
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 10
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 11                                                           
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 8
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 9
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 10
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 11      
                                                    )
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_total) }}</td>
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_receber) }}</td>
                                                        @php
                                                            $taxa = $venda->pagamento->valor_total - $venda->pagamento->valor_receber;
                                                        @endphp
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $taxa) }}</td>
                                                        <td style="text-align: center;">Pago Nordeste</td>
                                                        @break
                                                    @elseif (                                                                                                                    
                                                            $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 13
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 14
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 15
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 16                                                           
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 13
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 14
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 15
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 16      
                                                    )
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_total) }}</td>
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_receber) }}</td>
                                                        @php
                                                            $taxa = $venda->pagamento->valor_total - $venda->pagamento->valor_receber;
                                                        @endphp
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $taxa) }}</td>
                                                        <td style="text-align: center;">Pago Sudeste</td>
                                                        @break
                                                    @elseif (                                                                                                                    
                                                            $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 18
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 19
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 20
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 21                                                           
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 18
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 19
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 20
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 21      
                                                    )
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_total) }}</td>
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_receber) }}</td>
                                                        @php
                                                            $taxa = $venda->pagamento->valor_total - $venda->pagamento->valor_receber;
                                                        @endphp
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $taxa) }}</td>
                                                        <td style="text-align: center;">Pago Centro-Oeste</td>
                                                        @break
                                                    @elseif (                                                                                                                    
                                                            $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 23
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 24
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 25
                                                        || $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 26                                                           
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 23
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 24
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 25
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 26      
                                                    )
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_total) }}</td>
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_receber) }}</td>
                                                        @php
                                                            $taxa = $venda->pagamento->valor_total - $venda->pagamento->valor_receber;
                                                        @endphp
                                                        <td style="text-align: center;">{{ str_replace('.', ',', $taxa) }}</td>
                                                        <td style="text-align: center;">Pago Norte</td>
                                                        @break
                            
                                                    @elseif (                                                                                                                    
                                                           $venda->pagamento && $venda->pagamento->status_id == 3 && $venda->vendas_item && $venda->vendas_item->produto_id == 2
                                                        || $venda->pagamento && $venda->pagamento->status_id == 4 && $venda->vendas_item && $venda->vendas_item->produto_id == 2
                                                    )
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">Associado Isento</td>
                                                        @break
                                                    @endif

                                                    @if ($loop->last)
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">0,00</td>
                                                        <td style="text-align: center;">Associado Isento</td>
                                                        @break
                                                    @endif

                                                @endforeach
                                            @else
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: center;"></td>

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
