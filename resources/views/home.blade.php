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

        <!--MODAL Congressos Anuais-->
        <div class="modal fade" id="conregresso_nacional" tabindex="-1" aria-labelledby="conregresso_nacional" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="conregresso_nacionalLabel">Teste</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
