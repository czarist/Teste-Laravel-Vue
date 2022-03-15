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
    
    if ($status == 'sucess') {
        echo $div_status;
    }
    if ($status == 'error') {
        echo $div_status2;
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
                                <h4 class="" style="color:#FFF;">Congressos Anuais</h4>
                            </div>
                            <div class="inv-balance-info">
                            </div>
                        </div>
                        <div class="acc-action">
                            <div class="">
                            </div>
                            <a href="javascript:void(0);"  type="button" data-bs-toggle="modal"data-bs-target="#congressoanuais">Acesse</a>
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
                                <h4 class="" style="color:#FFF;">Cadastro Avaliadores</h4>
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

                        @if (Auth::user()->id != 1 || Auth::user()->id != 1868 || Auth::user()->id != 1156 || Auth::user()->id != 1859 || Auth::user()->id != 309)
                        Em desenvolvimento...
                        @endif

                        @if (Auth::user()->id == 1 || Auth::user()->id == 1868 || Auth::user()->id == 1156 || Auth::user()->id == 1859 || Auth::user()->id == 309 || Auth::user()->id == 1849)
                            
                            <div class="d-grid gap-2">
                                <a class="btn btn-primary m-1" href="{{ route('reginal.sul') }}">Regional Sul</a>
                                <a class="btn btn-primary m-1" href="{{ route('reginal.norte') }}">Regional Norte</a>
                                <a class="btn btn-primary m-1" href="{{ route('reginal.suldeste') }}">Regional Sudeste</a>
                                <a class="btn btn-primary m-1" href="{{ route('reginal.centrooeste') }}">Regional Centro Oeste</a>
                                <a class="btn btn-primary m-1" href="{{ route('reginal.nordeste') }}">Regional Nordeste</a>
                            </div>

                        @endif

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!--MODAL Congressos Anuais-->
        <div class="modal fade" id="congressoanuais" tabindex="-1" aria-labelledby="congressoanuais" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="congressoanuaisLabel">Congressos Anuais</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        Em desenvolvimento...
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
                        <h5 class="modal-title" id="formavaliadorLabel">Escolha o formulário para cadastro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">

                        <div class="d-grid gap-2">
                            <a class="btn btn-primary m-1" href="{{ route('avaliadorjr') }}">Form Avaliador DTs e IJs</a>
                            <a class="btn btn-primary m-1" href="{{ route('avaliadorexpocom') }}">Form Avaliador Expocom</a>
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
