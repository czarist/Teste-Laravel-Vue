$("#foruser").on("submit", function(event) {
    event.preventDefault();

    envio();

)};


function envio() {

var dados = $("#foruser").serializeArray();

$.ajax({
    method: "POST",
    url: "cadastro/save",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: $.param(dados),
    dataType: 'json',
    success: function(retorna) {
        console.log(retorna)
        if (retorna.message == 'error') {} else {
            console.log(retorna)

        }
    },
    error: function(retorna) {
        console.log(retorna)

    }
});
