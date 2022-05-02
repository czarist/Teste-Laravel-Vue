@extends('layouts.app')

@section('content')
<div class="col-12 mt-5">
    <?php
    $status = $_GET['status'] ?? null;
    
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
        <p><b>O seu pagamento foi processado com sucesso</b></p>
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

    <pagamento-grid ></pagamento-grid>
</div>
@endsection
