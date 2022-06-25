@extends('layouts.app')

@section('content')
    <?php
        $status = $_GET['status'] ?? '';
    
    ?>
    <?php
        $div_status = "<div class='col-12 alert alert-success text-center mt-3 mb-3' role='alert'>
            <h4 class='alert-heading'>Parabéns!</h4>
            <p><b>O seu pagamento de filiação foi processado com sucesso</b></p>
            <p><b>Assim que seu pagamento for aprovado será liberar a área de associado</b></p>
            Você foi direcionado para a página principal.<br/>
            Caso não tenha recebido o email contendo o status do seu pagamento, verifique sua caixa de spam.
        </div>";
        
        $div_status = "<div class='col-12 alert alert-success text-center mt-3 mb-3' role='alert'>
            <h4 class='alert-heading'>Parabéns!</h4>
            <p><b>O seu pagamento da sua anuidade foi processado com sucesso</b></p>
            <p><b>Assim que seu pagamento for aprovado será liberar a área de associado</b></p>
            Você foi direcionado para a página principal.<br/>
            Caso não tenha recebido o email contendo o status do seu pagamento, verifique sua caixa de spam.
        </div>";
        
        $div_status2 = "<div class='col-12 alert alert-danger text-center' role='alert'>
                <h4 class='alert-heading'>Alerta!</h4>
                <p><b>Seu pagamento teve um erro, acompanhe pela área de pagamentos</b></p>
            </div>";

        $div_status1 = "<div class='col-12 alert alert-success text-center mt-3 mb-3' role='alert'>
        <h4 class='alert-heading'>Parabéns!</h4>
        <p><b>Seu trabalho foi submetido com sucesso</b></p>
        Você foi direcionado para a página principal.<br/>
        </div>";

        
        if ($status == 'sucess') {
            echo $div_status;
        }
        if ($status == 'error') {
            echo $div_status2;
        }
        if ($status == 'sucess1') {
            echo $div_status1;
        }

    
    ?>

    <div class="row">
        <!--  BEGIN CONTENT AREA  -->
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-account-invoice-two">
                <div class="widget-content">
                    <div class="account-box">
                        <div class="info">
                            <div class="inv-title">
                                <h4 class="" style="color:#FFF;">Área do Associado</h4>
                            </div>
                            <div class="inv-balance-info">
                            </div>
                        </div>
                        <div class="acc-action">
                            <div class="">

                            </div>
                            <a href="{{ route('associado') }}">Acesse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-account-invoice-two">
                <div class="widget-content">
                    <div class="account-box">
                        <div class="info">
                            <div class="inv-title">
                                <h4 class="" style="color:#FFF;">Congressos Regionais</h4>
                            </div>
                            <div class="inv-balance-info">
                            </div>
                        </div>
                        <div class="acc-action">
                            <div class="">
                            </div>
                            <a href="javascript:void(0);" type="button" data-bs-toggle="modal"data-bs-target="#congressoregionais">Acesse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-account-invoice-two">
                <div class="widget-content">
                    <div class="account-box">
                        <div class="info">
                            <div class="inv-title">
                                <h4 class="" style="color:#FFF;">Congresso Nacional</h4>
                            </div>
                            <div class="inv-balance-info">
                            </div>
                        </div>
                        <div class="acc-action">
                            <div class="">
                            </div>
                            <a href="javascript:void(0);"  type="button" data-bs-toggle="modal"data-bs-target="#conregresso_nacional">Acesse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-account-invoice-two">
                <div class="widget-content">
                    <div class="account-box">
                        <div class="info">
                            <div class="inv-title">
                                <h4 class="" style="color:#FFF;">Área de Pagamento</h4>
                            </div>
                            <div class="inv-balance-info">
                            </div>
                        </div>
                        <div class="acc-action">
                            <div class="">
                            </div>
                            <a href="{{ route('pagamento.index') }}">Acesse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-account-invoice-two">
                <div class="widget-content">
                    <div class="account-box">
                        <div class="info">
                            <div class="inv-title">
                                <h4 class="" style="color:#FFF;">
                                    @if (Auth::user()->is_avaliador_2022)
                                        Área do Avaliador
                                    @else
                                        Cadastro Avaliadores
                                    @endif


                                </h4>
                            </div>
                            <div class="inv-balance-info">
                            </div>
                        </div>
                        <div class="acc-action">
                            <div class="">
                            </div>
                            <a href="javascript:void(0);"  type="button" data-bs-toggle="modal"data-bs-target="#formavaliador">Acesse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()->is_admin || Auth::user()->is_coordenador2022)
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-account-invoice-two">
                    <div class="widget-content">
                        <div class="account-box">
                            <div class="info">
                                <div class="inv-title">
                                    <h4 class="" style="color:#FFF;">Área do Coordenador </h4>
                                </div>
                                <div class="inv-balance-info">
                                </div>
                            </div>
                            <div class="acc-action">
                                <div class="">
                                </div>
                                <a href="javascript:void(0);"  type="button" data-bs-toggle="modal"data-bs-target="#cadascooravali">Acesse</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <!--  END CONTENT AREA  -->

        <!--MODAL Congressos Regionais-->
        <div class="modal fade" id="congressoregionais" tabindex="-1" aria-labelledby="congressoregionais"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="congressoregionaisLabel">Congressos Regionais</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar">X</button>
                    </div>
                    <div class="modal-body">
                        <div class="d-grid gap-2">

                            <div class="text-center">
                                <h6>Minhas Submissões </h6>
                            </div>

                            <div class="row">
                                <div class="col-6 text-center">
                                    <a class="btn btn-success m-1" href="{{ route('submissao.index') }}">Ver minhas submissões - DT, IJ e MESA</a>    
                                </div>
                                <div class="col-6 text-center">
                                    <a class="btn btn-success m-1" href="{{ route('submissao-expocom.index') }}">Ver minhas submissões - Expocom</a>    
                                </div>
                            </div>

                            <hr>


                            @if (
                                    Auth::user()->pago_regional_sul_2022 
                                    || Auth::user()->pago_regional_nordeste_2022 
                                    || Auth::user()->pago_regional_suldeste_2022 
                                    || Auth::user()->pago_regional_centrooeste_2022 
                                    || Auth::user()->pago_regional_norte_2022

                            )                                        
                                @if (Auth::user()->pago_regional_sul_2022)

                                    @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-06-01 00:00:00')                                    
                                        <div class="text-center">
                                            <h6>Inscrição</h6>
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-success m-1" href="{{ route('regional.sul') }}">
                                                @if (Auth::user()->regional_sul)
                                                    Alterar Inscrição - Regional Sul
                                                @endif
                                                @if (!Auth::user()->regional_sul)
                                                    Inscrição - Regional Sul
                                                @endif
                                            </a>
                                        </div>
                                        <hr>   
                                    @endif 

                                    <div class="text-center">
                                        <h6>Submissão de Trabalho</h6>
                                    </div>

                                    @if (
                                        Auth::user()->regional_sul && Auth::user()->regional_sul->categoria_inscricao && Auth::user()->regional_sul->categoria_inscricao == 1                                         
                                        || Auth::user()->regional_sul && Auth::user()->regional_sul->categoria_inscricao && Auth::user()->regional_sul->categoria_inscricao == 2 
                                        || Auth::user()->regional_sul && Auth::user()->regional_sul->categoria_inscricao && Auth::user()->regional_sul->categoria_inscricao == 10                                        
                                        )

                                            <div class="row text-center">
                                                @if (Auth::user()->is_indicado_expocom_2022)
                                                <div class="col-6">
                                                    <a class="btn btn-primary m-1" href="{{ route('submissaoexpocom.regional.sul') }}">Submissão Expocom Regional Sul</a>                                        
                                                </div>      
                                                @endif

                                                <div class="{{ Auth::user()->is_indicado_expocom_2022 ? 'col-6' : 'col-12'  }}">
                                                    <a class="btn btn-primary m-1" href="{{ route('submissaojunior.regional.sul') }}">Submissão Intercom Júnior Regional Sul</a>    
                                                </div>
                                            </div>

                                    @endif

                                    @if (
                                        Auth::user() && Auth::user()->regional_sul && Auth::user()->regional_sul->categoria_inscricao && Auth::user()->regional_sul->categoria_inscricao == 3 
                                        || Auth::user() && Auth::user()->regional_sul && Auth::user()->regional_sul->categoria_inscricao && Auth::user()->regional_sul->categoria_inscricao == 4
                                        || Auth::user() && Auth::user()->regional_sul && Auth::user()->regional_sul->categoria_inscricao &&  Auth::user()->regional_sul->categoria_inscricao == 5
                                        || Auth::user() && Auth::user()->regional_sul && Auth::user()->regional_sul->categoria_inscricao && Auth::user()->regional_sul->categoria_inscricao == 6
                                        || Auth::user() && Auth::user()->regional_sul && Auth::user()->regional_sul->categoria_inscricao && Auth::user()->regional_sul->categoria_inscricao == 7
                                        || Auth::user() && Auth::user()->regional_sul && Auth::user()->regional_sul->categoria_inscricao && Auth::user()->regional_sul->categoria_inscricao == 8
                                        || Auth::user() && Auth::user()->regional_sul && Auth::user()->regional_sul->categoria_inscricao && Auth::user()->regional_sul->categoria_inscricao == 9

                                    )
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <a class="btn btn-primary m-1" href="{{ route('submissao.regional.sul') }}">Submissão Divisões Temáticas Regional Sul</a>
                                            </div>                                                    
                                            <div class="col-6">
                                                <a class="btn btn-primary m-1" href="{{ route('submissaomesa.regional.sul') }}">Submissão Mesa Regional Sul</a>                                                                             
                                            </div>
                                        </div>

                                    @endif
                                    <hr>    
                                    <hr>    

                                @endif

                                @if (Auth::user()->pago_regional_nordeste_2022) 
                                    @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-05-04 00:00:00')                                    
                                        <div class="text-center">
                                            <h6>Inscrição</h6>
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-success m-1" href="{{ route('regional.nordeste') }}">
                                                @if (Auth::user()->regional_nordeste)
                                                    Alterar Inscrição - Regional Nordeste
                                                @endif
                                                @if (!Auth::user()->regional_nordeste)
                                                    Inscrição - Regional Nordeste
                                                @endif
                                            </a>
                                        </div>
                                        <hr>    
                                    @endif

                                    <div class="text-center">
                                        <h6>Submissão de Trabalho</h6>
                                    </div>
                               
                                    @if (
                                        Auth::user()->regional_nordeste && Auth::user()->regional_nordeste->categoria_inscricao && Auth::user()->regional_nordeste->categoria_inscricao == 1                                         
                                        || Auth::user()->regional_nordeste && Auth::user()->regional_nordeste->categoria_inscricao && Auth::user()->regional_nordeste->categoria_inscricao == 2 
                                        || Auth::user()->regional_nordeste && Auth::user()->regional_nordeste->categoria_inscricao && Auth::user()->regional_nordeste->categoria_inscricao == 10
                                        )

                                            <div class="row text-center">
                                                @if (Auth::user()->is_indicado_expocom_2022)
                                                <div class="col-6">
                                                    <a class="btn btn-primary m-1" href="{{ route('submissaoexpocom.regional.nordeste') }}">Submissão Expocom Regional Nordeste</a>                                        
                                                </div>      
                                                @endif

                                                <div class="{{ Auth::user()->is_indicado_expocom_2022 ? 'col-6' : 'col-12'  }}">
                                                    <a class="btn btn-primary m-1" href="{{ route('submissaojunior.regional.nordeste') }}">Submissão Intercom Júnior Regional Nordeste</a>                                        
                                                </div>
                                            </div>

                                    @endif

                                    @if (
                                        Auth::user()->regional_nordeste && Auth::user()->regional_nordeste->categoria_inscricao && Auth::user()->regional_nordeste->categoria_inscricao == 3                                         
                                        || Auth::user()->regional_nordeste && Auth::user()->regional_nordeste->categoria_inscricao &&  Auth::user()->regional_nordeste->categoria_inscricao == 4
                                        || Auth::user()->regional_nordeste && Auth::user()->regional_nordeste->categoria_inscricao && Auth::user()->regional_nordeste->categoria_inscricao == 5
                                        || Auth::user()->regional_nordeste && Auth::user()->regional_nordeste->categoria_inscricao && Auth::user()->regional_nordeste->categoria_inscricao == 6
                                        || Auth::user()->regional_nordeste && Auth::user()->regional_nordeste->categoria_inscricao && Auth::user()->regional_nordeste->categoria_inscricao == 7
                                        || Auth::user()->regional_nordeste && Auth::user()->regional_nordeste->categoria_inscricao && Auth::user()->regional_nordeste->categoria_inscricao == 8
                                        || Auth::user()->regional_nordeste && Auth::user()->regional_nordeste->categoria_inscricao && Auth::user()->regional_nordeste->categoria_inscricao == 9

                                    )
                                        <div class="row">
                                            <div class="col-6">
                                                <a class="btn btn-primary m-1" href="{{ route('submissao.regional.nordeste') }}">Submissão Divisões Temáticas Regional Nordeste</a>
                                            </div>                                                    
                                            <div class="col-6">
                                                <a class="btn btn-primary m-1" href="{{ route('submissaomesa.regional.nordeste') }}">Submissão Mesa Regional Nordeste</a>                                                                             
                                            </div>
                                        </div>

                                    @endif
                                    <hr>    
                                    <hr>    

                                @endif

                                @if (Auth::user()->pago_regional_suldeste_2022)

                                    @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-05-11 00:00:00')                                    
                                        <div class="text-center">
                                            <h6>Inscrição</h6>
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-success m-1" href="{{ route('regional.suldeste') }}">
                                                @if (Auth::user()->regional_suldeste)
                                                    Alterar Inscrição - Regional Sudeste
                                                @endif
                                                @if (!Auth::user()->regional_suldeste)
                                                    Inscrição - Regional Sudeste
                                                @endif                                        
                                            </a>
                                        </div>
                                        <hr>
                                    @endif

                                    <div class="text-center">
                                        <h6>Submissão de Trabalho</h6>
                                    </div>
                                                                                
                                    @if (
                                        Auth::user()->regional_suldeste && Auth::user()->regional_suldeste->categoria_inscricao && Auth::user()->regional_suldeste->categoria_inscricao == 1                                         
                                        || Auth::user()->regional_suldeste && Auth::user()->regional_suldeste->categoria_inscricao && Auth::user()->regional_suldeste->categoria_inscricao == 2 
                                        || Auth::user()->regional_suldeste && Auth::user()->regional_suldeste->categoria_inscricao && Auth::user()->regional_suldeste->categoria_inscricao == 10
                                        )

                                            <div class="row text-center">
                                                @if (Auth::user()->is_indicado_expocom_2022)
                                                <div class="col-6">
                                                    <a class="btn btn-primary m-1" href="{{ route('submissaoexpocom.regional.suldeste') }}">Submissão Expocom Regional Sudeste</a>                                        
                                                </div>      
                                                @endif

                                                <div class="{{ Auth::user()->is_indicado_expocom_2022 ? 'col-6' : 'col-12'  }}">
                                                    <a class="btn btn-primary m-1" href="{{ route('submissaojunior.regional.suldeste') }}">Submissão Intercom Júnior Regional Sudeste</a>                                        
                                                </div>
                                            </div>

                                    @endif

                                    @if (
                                        Auth::user()->regional_suldeste && Auth::user()->regional_suldeste->categoria_inscricao && Auth::user()->regional_suldeste->categoria_inscricao == 3                                         
                                        || Auth::user()->regional_suldeste && Auth::user()->regional_suldeste->categoria_inscricao && Auth::user()->regional_suldeste->categoria_inscricao == 4
                                        || Auth::user()->regional_suldeste && Auth::user()->regional_suldeste->categoria_inscricao && Auth::user()->regional_suldeste->categoria_inscricao == 5
                                        || Auth::user()->regional_suldeste && Auth::user()->regional_suldeste->categoria_inscricao && Auth::user()->regional_suldeste->categoria_inscricao == 6
                                        || Auth::user()->regional_suldeste && Auth::user()->regional_suldeste->categoria_inscricao && Auth::user()->regional_suldeste->categoria_inscricao == 7
                                        || Auth::user()->regional_suldeste && Auth::user()->regional_suldeste->categoria_inscricao && Auth::user()->regional_suldeste->categoria_inscricao == 8
                                        || Auth::user()->regional_suldeste && Auth::user()->regional_suldeste->categoria_inscricao && Auth::user()->regional_suldeste->categoria_inscricao == 9
                                    )
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <a class="btn btn-primary m-1" href="{{ route('submissao.regional.suldeste') }}">Submissão Divisões Temáticas Regional Sudeste</a>
                                            </div>                                                    
                                            <div class="col-6">
                                                <a class="btn btn-primary m-1" href="{{ route('submissaomesa.regional.suldeste') }}">Submissão Mesa Regional Sudeste</a>                                                                             
                                            </div>
                                        </div>
                                    @endif
                                    <hr>    
                                    <hr>    

                                @endif

                                @if (Auth::user()->pago_regional_centrooeste_2022)

                                    @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-05-25 00:00:00')                                    
                                        <div class="text-center">
                                            <h6>Inscrição</h6>
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-success m-1" href="{{ route('regional.centrooeste') }}">
                                                @if (Auth::user()->regional_centrooeste)
                                                    Alterar Inscrição - Regional Centro Oeste
                                                @endif
                                                @if (!Auth::user()->regional_centrooeste)
                                                    Inscrição - Regional Centro Oeste
                                                @endif
                                        
                                            </a>
                                        </div>
                                        <hr>  
                                    @endif
                                      
                                    <div class="text-center">
                                        <h6>Submissão de Trabalho</h6>
                                    </div>
                                
                                    @if (
                                        Auth::user()->regional_centrooeste && Auth::user()->regional_centrooeste->categoria_inscricao && Auth::user()->regional_centrooeste->categoria_inscricao == 1                                         
                                        || Auth::user()->regional_centrooeste && Auth::user()->regional_centrooeste->categoria_inscricao && Auth::user()->regional_centrooeste->categoria_inscricao == 2 
                                        || Auth::user()->regional_centrooeste && Auth::user()->regional_centrooeste->categoria_inscricao && Auth::user()->regional_centrooeste->categoria_inscricao == 10
                                        )

                                            <div class="row text-center">
                                                @if (Auth::user()->is_indicado_expocom_2022)
                                                <div class="col-6">
                                                    <a class="btn btn-primary m-1" href="{{ route('submissaoexpocom.regional.centrooeste') }}">Submissão Expocom Regional Centro-Oeste</a>                                        
                                                </div>      
                                                @endif

                                                <div class="{{ Auth::user()->is_indicado_expocom_2022 ? 'col-6' : 'col-12'  }}">
                                                    <a class="btn btn-primary m-1" href="{{ route('submissaojunior.regional.centrooeste') }}">Submissão Intercom Júnior Regional Centro-Oeste</a>                                        
                                                </div>
                                            </div>

                                    @endif

                                    @if (
                                        Auth::user()->regional_centrooeste && Auth::user()->regional_centrooeste->categoria_inscricao && Auth::user()->regional_centrooeste->categoria_inscricao == 3
                                        || Auth::user()->regional_centrooeste && Auth::user()->regional_centrooeste->categoria_inscricao && Auth::user()->regional_centrooeste->categoria_inscricao == 4
                                        || Auth::user()->regional_centrooeste && Auth::user()->regional_centrooeste->categoria_inscricao && Auth::user()->regional_centrooeste->categoria_inscricao == 5
                                        || Auth::user()->regional_centrooeste && Auth::user()->regional_centrooeste->categoria_inscricao && Auth::user()->regional_centrooeste->categoria_inscricao == 6
                                        || Auth::user()->regional_centrooeste && Auth::user()->regional_centrooeste->categoria_inscricao && Auth::user()->regional_centrooeste->categoria_inscricao == 7
                                        || Auth::user()->regional_centrooeste && Auth::user()->regional_centrooeste->categoria_inscricao && Auth::user()->regional_centrooeste->categoria_inscricao == 8
                                        || Auth::user()->regional_centrooeste && Auth::user()->regional_centrooeste->categoria_inscricao && Auth::user()->regional_centrooeste->categoria_inscricao == 9
                                    )
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <a class="btn btn-primary m-1" href="{{ route('submissao.regional.centrooeste') }}">Submissão Divisões Temáticas Regional Centro-Oeste</a>
                                            </div>                                                    
                                            <div class="col-6">
                                                <a class="btn btn-primary m-1" href="{{ route('submissaomesa.regional.centrooeste') }}">Submissão Mesa Regional Centro-Oeste</a>                                                                             
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <hr>
                                    <div class="col-12 text-center">
                                        <a class="btn btn-primary m-1" href="{{ route('lista-trabalho-expocom.view', ['regiao_id' => 4]) }}">Lista de Trabalhos - Centro-Oeste</a>
                                    </div>                                                    
    
                                    <hr>    
                                    <hr>    

                                @endif

                                @if (Auth::user()->pago_regional_norte_2022)

                                    @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-05-18 00:00:00')                                    
                                        <div class="text-center">
                                            <h6>Inscrição</h6>
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-success m-1" href="{{ route('regional.norte') }}">
                                                @if (Auth::user()->regional_norte)
                                                    Alterar Inscrição - Regional Norte
                                                @endif
                                                @if (!Auth::user()->regional_norte)
                                                Inscrição - Regional Norte
                                            @endif                                        
                                            </a>
                                        </div>
                                        <hr>
                                    @endif

                                    <div class="text-center">
                                        <h6>Submissão de Trabalho</h6>
                                    </div>
                                
                                    @if (
                                        Auth::user()->regional_norte && Auth::user()->regional_norte->categoria_inscricao && Auth::user()->regional_norte->categoria_inscricao == 1                                         
                                        || Auth::user()->regional_norte && Auth::user()->regional_norte->categoria_inscricao && Auth::user()->regional_norte->categoria_inscricao == 2 
                                        || Auth::user()->regional_norte && Auth::user()->regional_norte->categoria_inscricao && Auth::user()->regional_norte->categoria_inscricao == 10
                                        )

                                            <div class="row text-center">
                                                @if (Auth::user()->is_indicado_expocom_2022)
                                                <div class="col-6">
                                                    <a class="btn btn-primary m-1" href="{{ route('submissaoexpocom.regional.norte') }}">Submissão Expocom Regional Norte</a>                                        
                                                </div>      
                                                @endif

                                                <div class="{{ Auth::user()->is_indicado_expocom_2022 ? 'col-6' : 'col-12'  }}">
                                                    <a class="btn btn-primary m-1" href="{{ route('submissaojunior.regional.norte') }}">Submissão Intercom Júnior Regional Norte</a>                                        
                                                </div>
                                            </div>

                                    @endif

                                    @if (
                                        Auth::user()->regional_norte && Auth::user()->regional_norte->categoria_inscricao && Auth::user()->regional_norte->categoria_inscricao == 3 
                                        || Auth::user()->regional_norte && Auth::user()->regional_norte->categoria_inscricao && Auth::user()->regional_norte->categoria_inscricao == 4
                                        || Auth::user()->regional_norte && Auth::user()->regional_norte->categoria_inscricao && Auth::user()->regional_norte->categoria_inscricao == 5
                                        || Auth::user()->regional_norte && Auth::user()->regional_norte->categoria_inscricao && Auth::user()->regional_norte->categoria_inscricao == 6
                                        || Auth::user()->regional_norte && Auth::user()->regional_norte->categoria_inscricao && Auth::user()->regional_norte->categoria_inscricao == 7
                                        || Auth::user()->regional_norte && Auth::user()->regional_norte->categoria_inscricao && Auth::user()->regional_norte->categoria_inscricao == 8
                                        || Auth::user()->regional_norte && Auth::user()->regional_norte->categoria_inscricao && Auth::user()->regional_norte->categoria_inscricao == 9
                                    )
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <a class="btn btn-primary m-1" href="{{ route('submissao.regional.norte') }}">Submissão Divisões Temáticas Regional Norte</a>
                                            </div>                                                    
                                            <div class="col-6">
                                                <a class="btn btn-primary m-1" href="{{ route('submissaomesa.regional.norte') }}">Submissão Mesa Regional Norte</a>                                                                             
                                            </div>
                                        </div>
                                    @endif

                                    <hr>
                                    <div class="col-12 text-center">
                                        <a class="btn btn-primary m-1" href="{{ route('lista-trabalho-expocom.view', ['regiao_id' => 5]) }}">Lista de Trabalhos - Norte</a>
                                    </div>                                                    

                                @endif
                            @else

                                <div class="row">
                                    @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-06-01 00:00:00')                                    
                                        <div class="col-6">
                                            <a class="btn btn-primary m-1" href="{{ route('regional.sul') }}">Regional Sul</a>
                                        </div>
                                    @endif

                                    @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-05-18 00:00:00')                                    
                                        <div class="col-6">
                                            <a class="btn btn-primary m-1" href="{{ route('regional.norte') }}">Regional Norte</a>
                                        </div>
                                    @endif

                                    @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-05-11 00:00:00')                                    
                                        <div class="col-6">
                                            <a class="btn btn-primary m-1" href="{{ route('regional.suldeste') }}">Regional Sudeste</a>
                                        </div>
                                    @endif

                                    @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-05-25 00:00:00')                                    
                                        <div class="col-6">
                                            <a class="btn btn-primary m-1" href="{{ route('regional.centrooeste') }}">Regional Centro Oeste</a>
                                        </div>
                                    @endif

                                    @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-05-04 00:00:00')                                    
                                        <div class="col-6">
                                            <a class="btn btn-primary m-1" href="{{ route('regional.nordeste') }}">Regional Nordeste</a>
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!--MODAL Congressos Anuais-->
        <div class="modal fade" id="conregresso_nacional" tabindex="-1" aria-labelledby="conregresso_nacional" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="conregresso_nacionalLabel">Formulários de inscrições</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            
                            @if (Auth::user()->pago_nacional_2022)
                                @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-08-12 00:00:00') 
                                    <div class="col-12 text-center">
                                        
                                        <div class="text-center">
                                            <h6>Inscrição</h6>
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-success m-1" href="{{ route('nacional') }}">
                                                @if (Auth::user()->nacional)
                                                    Alterar Inscrição - Nacional
                                                @endif
                                                @if (!Auth::user()->nacional)
                                                    Inscrição - Nacional
                                                @endif                                        
                                            </a>
                                        </div>
                                    </div>
                                    <hr>
                                @endif

                                @if (                                    
                                    Auth::user() && Auth::user()->nacional && Auth::user()->nacional->categoria_inscricao && Auth::user()->nacional->categoria_inscricao == 3
                                    || Auth::user() && Auth::user()->nacional && Auth::user()->nacional->categoria_inscricao && Auth::user()->nacional->categoria_inscricao == 4
                                    || Auth::user() && Auth::user()->nacional && Auth::user()->nacional->categoria_inscricao && Auth::user()->nacional->categoria_inscricao == 5
                                    || Auth::user() && Auth::user()->nacional && Auth::user()->nacional->categoria_inscricao && Auth::user()->nacional->categoria_inscricao == 6
                                    || Auth::user() && Auth::user()->nacional && Auth::user()->nacional->categoria_inscricao && Auth::user()->nacional->categoria_inscricao == 7
                                    || Auth::user() && Auth::user()->nacional && Auth::user()->nacional->categoria_inscricao && Auth::user()->nacional->categoria_inscricao == 8
                                    || Auth::user() && Auth::user()->nacional && Auth::user()->nacional->categoria_inscricao && Auth::user()->nacional->categoria_inscricao == 9
                                )
                                    <div class="col-12 text-center">
                                        <a class="btn btn-primary m-1" href="{{ route('submissao.nacional.gp') }}">Submissão GP - Nacional</a>
                                    </div>

                                    <div class="col-12 text-center">
                                        <a class="btn btn-primary m-1" href="{{ route('submissao.nacional.publicom') }}">Submissão Publicom - Nacional</a>
                                    </div>
                                    
                                @endif

                                @if (                                    
                                    Auth::user() && Auth::user()->nacional && Auth::user()->nacional->categoria_inscricao && Auth::user()->nacional->categoria_inscricao == 1
                                    || Auth::user() && Auth::user()->nacional && Auth::user()->nacional->categoria_inscricao && Auth::user()->nacional->categoria_inscricao == 2
                                    || Auth::user() && Auth::user()->nacional && Auth::user()->nacional->categoria_inscricao && Auth::user()->nacional->categoria_inscricao == 10
                                )
                                    <div class="col-12 text-center">Alterar Cadastro Avaliador DTs e IJs
                                        <a class="btn btn-primary m-1" href="{{ route('submissao.nacional.junior') }}">Submissão Intercom Júnior - Nacional</a>
                                    </div>                                    
                                @endif

                            @else
                                @if (\Carbon\Carbon::now()->format('Y-m-d H:i:s') <= '2022-08-12 00:00:00')                                    
                                    <div class="col-12 text-center">
                                        <a class="btn btn-primary m-1" href="{{ route('nacional') }}">Inscricão Nacional</a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!--MODAL FORM AVALIADOR-->
        <div class="modal fade" id="formavaliador" tabindex="-1" aria-labelledby="formavaliador" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formavaliadorLabel">Área do Avaliador</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">

                        @if (Auth::user()->is_avaliador_2022)
                            <div class="d-grid gap-2 text-center">
                                <h6>Avaliação de Trabalhos</h6>

                                @if (Auth::user()->avaliador_expocom && Auth::user()->avaliador_expocom->avaliador == 1)
                                    <a class="btn btn-primary m-1" href="{{ route('avaliador-expocom.index') }}">Acesso aos trabalhos designados para a sua avaliação - Expocom</a>
                                @endif

                                @if (Auth::user()->avaliador_expocom && Auth::user()->avaliador_expocom->avaliador_junior == 1)
                                    <a class="btn btn-primary m-1" href="{{ route('avaliador.index') }}">Acesso aos trabalhos designados para a sua avaliação - DT, IJ e MESA</a>
                                @endif
                            </div>
                        @endif
                        <hr>
                        <hr>
                        <div class="d-grid gap-2 text-center">
                            <h6>
                                {{ Auth::user()->is_avaliador_2022 ? "Alterar Cadastro de Avaliador Regional" : "Inscrição de Avaliador Regional" }}
                            </h6>

                            <a class="btn btn-success m-1" href="{{ route('avaliadorjr') }}">
                                {{ Auth::user() && Auth::user()->is_avaliador_2022  ?  "Alterar Cadastro Avaliador Regional DTs e IJs" :   "Cadastro de Avaliador Regional DTs e IJs" }}
                            </a>

                            <a class="btn btn-success m-1" href="{{ route('avaliadorexpocom') }}">
                                {{ Auth::user() && Auth::user()->is_avaliador_2022  ?  "Alterar Cadastro Avaliador Regional Expocom" :   "Cadastro de Avaliador Regional Expocom" }}
                            </a>

                            <hr>

                            <h6>
                                {{ Auth::user()->is_avaliador_nacional_2022 ? "Alterar Cadastro de Avaliador Nacional" : "Inscrição de Avaliador Nacional" }}
                            </h6>

                            <a class="btn btn-success m-1" href="{{ route('avaliador.nacional.jr') }}">
                                {{ Auth::user() && Auth::user()->is_avaliador_nacional_2022  ?  "Alterar Cadastro Avaliador Nacional IJ" :   "Cadastro de Avaliador Nacional IJ" }}
                            </a>

                            <a class="btn btn-success m-1" href="{{ route('avaliador.nacional.gp') }}">
                                {{ Auth::user() && Auth::user()->is_avaliador_nacional_2022  ?  "Alterar Cadastro Avaliador Nacional GP" :   "Cadastro de Avaliador Nacional GP" }}
                            </a>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!--MODAL CADASTRO DE AVALIADORES E COORDENADOR-->
        <div class="modal fade" id="cadascooravali" tabindex="-1" aria-labelledby="cadascooravali" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cadascooravaliLabel">Escolha o tipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">

                        <div class="d-grid gap-2 text-center">

                            @if (Auth::user()->coordenador_regional && Auth::user()->coordenador_regional->tipo == "Expocom")

                                <h5 class="text-center">Regional - Expocom</h5>

                                <a class="btn btn-primary m-1" href="{{ route('avaliacaoexpocom.view',1) }}">Distribuição de trabalhos para avaliadores - Expocom - Sul</a>   
                                
                                <a class="btn btn-primary m-1" href="{{ route('avaliacaoexpocom.view',2) }}">Distribuição de trabalhos para avaliadores - Expocom - Nordeste</a>                                

                                <a class="btn btn-primary m-1" href="{{ route('avaliacaoexpocom.view',3) }}">Distribuição de trabalhos para avaliadores - Expocom - Sudeste</a>                                

                                <a class="btn btn-primary m-1" href="{{ route('avaliacaoexpocom.view',4) }}">Distribuição de trabalhos para avaliadores - Expocom - Centro-Oeste</a>                                

                                <a class="btn btn-primary m-1" href="{{ route('avaliacaoexpocom.view',5) }}">Distribuição de trabalhos para avaliadores - Expocom - Norte</a> 
                                
                                <a class="btn btn-primary m-1" href="{{ route('validar-apresentacao-expocom.index') }}">Validar Apresentação de Trabalhos e Vencedor Expocom</a> 

                            @endif

                            @if (Auth::user()->coordenador_regional && Auth::user()->coordenador_regional->tipo != "Expocom")
                                <h5 class="text-center">Regional - DT, IJ e MESA</h5>
                                <a class="btn btn-primary m-1" href="{{ route('avaliacao.index') }}">Distribuição de trabalhos para avaliadores - DT, IJ e MESA</a>
                                <a class="btn btn-primary m-1" href="{{ route('validar-apresentacao.index') }}">Validar Apresentação de Trabalhos e Vencedor</a> 
                            @endif

                            @if (Auth::user()->nacional && Auth::user()->nacional->tipo = 2)
                                <h5 class="text-center">Nacional Intercom Júnior</h5>
                                <a class="btn btn-primary m-1" href="{{ route('avaliacao_nacional.index') }}">Avaliação de trabalho - Nacional</a>
                                <a class="btn btn-primary m-1" href="{{ route('validar-apresentacao-nacional.index') }}">Validar Apresentação de Trabalhos e Vencedor</a> 
                            @endif

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@endsection
