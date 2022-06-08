<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<table border="1">
    <thead>
        <tr style="background: #E7E7E7;">
            <th scope="col" style="font-size: 1em;" class="align-middle pl-2 text-center">NOME</th>
            <th scope="col" style="font-size: 1em;" class="align-middle pl-2 text-center">REGIÃO</th>
            <th scope="col" style="font-size: 1em;" class="align-middle pl-2 text-center">VLR BRUTO</th>
            <th scope="col" style="font-size: 1em;" class="align-middle pl-2 text-center">VLR LIQUIDO</th>
            <th scope="col" style="font-size: 1em;" class="align-middle pl-2 text-center">TAXAS</th>
            <th scope="col" style="font-size: 1em;" class="align-middle pl-2 text-center">TIPO</th>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td style="text-align: center;">{{ $user->name }}</td>
                        @if ($tipo == 6)
                            @foreach ($user->todos_tipos_pagamentos as $tipo_pagamento)
                                @if ($tipo_pagamento->id == 1)
                                    @foreach ($user->vendas as $venda)
                                        @if (
                                            $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 3 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 3 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 4 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 4 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 5 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 5 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 6 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 6 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        )
                                            <td style="text-align: center;">Sul</td>
                                            <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_total) ?? "0,00"}} </td>
                                            <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_receber) ?? "0,00"}} </td>
                                            @php
                                                $taxa = $venda->pagamento->valor_total - $venda->pagamento->valor_receber;
                                            @endphp
                                            <td style="text-align: center;">{{ str_replace('.', ',', $taxa) ?? "0,00" }}</td>
                                            <td style="text-align: center;">Pagou Sul</td>                                    
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
                        @elseif($tipo == 7)
                            @foreach ($user->todos_tipos_pagamentos as $tipo_pagamento)

                                @if ($tipo_pagamento->id == 4)
                                    @foreach ($user->vendas as $venda)
                                        @if (
                                            $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 8 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 8 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 9 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 9 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 10 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 10 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 11 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 11 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        )
                                            <td style="text-align: center;">Nordeste</td>
                                            <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_total) ?? "0,00"}} </td>
                                            <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_receber) ?? "0,00"}} </td>
                                            @php
                                                $taxa = $venda->pagamento->valor_total - $venda->pagamento->valor_receber;
                                            @endphp
                                            <td style="text-align: center;">{{ str_replace('.', ',', $taxa) ?? "0,00" }}</td>
                                            <td style="text-align: center;">Pagou Nordeste</td>                                    
                                        @endif
                                    @endforeach
                                @elseif($tipo_pagamento->id == 5)
                                    <td style="text-align: center;">Nordeste</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">Usuário Isento</td>
                                @elseif($tipo_pagamento->id == 6)
                                    <td style="text-align: center;">Nordeste</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">Associado Isento</td>
                                @endif
                            @endforeach

                        @elseif($tipo == 8)
                            @foreach ($user->todos_tipos_pagamentos as $tipo_pagamento)

                                @if ($tipo_pagamento->id == 7)

                                    @foreach ($user->vendas as $venda)

                                        @if (
                                            $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 13 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 13 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 14 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 14 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 15 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 15 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 16 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 16 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        )

                                            <td style="text-align: center;">Sudeste</td>
                                            <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_total) ?? "0,00"}} </td>
                                            <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_receber) ?? "0,00"}} </td>
                                            @php
                                                $taxa = $venda->pagamento->valor_total - $venda->pagamento->valor_receber;
                                            @endphp
                                            <td style="text-align: center;">{{ str_replace('.', ',', $taxa) ?? "0,00" }}</td>
                                            <td style="text-align: center;">Pagou Sudeste</td>  

                                        @endif

                                    @endforeach

                                @elseif($tipo_pagamento->id == 8)

                                    <td style="text-align: center;">Sudeste</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">Usuário Isento</td>

                                @elseif($tipo_pagamento->id == 9)

                                    <td style="text-align: center;">Sudeste</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">Associado Isento</td>

                                @endif
                            @endforeach

                        @elseif($tipo == 9)
                            @foreach ($user->todos_tipos_pagamentos as $tipo_pagamento)
                                @if ($tipo_pagamento->id == 10)

                                    @foreach ($user->vendas as $venda)

                                        @if (
                                            $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 18 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 18 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 19 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 19 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 20 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 20 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 21 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 21 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        )

                                            <td style="text-align: center;">Centro-Oeste</td>
                                            <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_total) ?? "0,00"}} </td>
                                            <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_receber) ?? "0,00"}} </td>
                                            @php
                                                $taxa = $venda->pagamento->valor_total - $venda->pagamento->valor_receber;
                                            @endphp
                                            <td style="text-align: center;">{{ str_replace('.', ',', $taxa) ?? "0,00" }}</td>
                                            <td style="text-align: center;">Pagou Centro-Oeste</td>  

                                        @endif

                                    @endforeach

                                @elseif($tipo_pagamento->id == 11)

                                    <td style="text-align: center;">Centro-Oeste</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">Usuário Isento</td>

                                @elseif($tipo_pagamento->id == 12)

                                    <td style="text-align: center;">Centro-Oeste</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">Associado Isento</td>

                                @endif
                            @endforeach
                        @elseif($tipo == 10)
                            @foreach ($user->todos_tipos_pagamentos as $tipo_pagamento)
                                @if ($tipo_pagamento->id == 13)

                                    @foreach ($user->vendas as $venda)

                                        @if (
                                            $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 23 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 23 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 24 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 24 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 25 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 25 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 26 && $venda->pagamento && $venda->pagamento->status_id == 3
                                        ||  $venda && $venda->vendas_item && $venda->vendas_item->produto_id == 26 && $venda->pagamento && $venda->pagamento->status_id == 4
                                        )

                                            <td style="text-align: center;">Norte</td>
                                            <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_total) ?? "0,00"}} </td>
                                            <td style="text-align: center;">{{ str_replace('.', ',', $venda->pagamento->valor_receber) ?? "0,00"}} </td>
                                            @php
                                                $taxa = $venda->pagamento->valor_total - $venda->pagamento->valor_receber;
                                            @endphp
                                            <td style="text-align: center;">{{ str_replace('.', ',', $taxa) ?? "0,00" }}</td>
                                            <td style="text-align: center;">Pagou Norte</td>  

                                        @endif

                                    @endforeach

                                @elseif($tipo_pagamento->id == 14)

                                    <td style="text-align: center;">Norte</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">0,00</td>
                                    <td style="text-align: center;">Usuário Isento</td>

                                @elseif($tipo_pagamento->id == 15)

                                    <td style="text-align: center;">Norte</td>
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
