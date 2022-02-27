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

if($status == 'sucess'){
    echo $div_status;
}
if($status == 'error'){
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
                            <a href="javascript:void(0);">Acesse</a>
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
                            <a href="javascript:void(0);">Acesse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--  END CONTENT AREA  -->
    </div>
@endsection
    