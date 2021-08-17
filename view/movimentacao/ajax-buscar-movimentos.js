$(document).ready(function () {
    $('#conta_id').change(function (e) {
        var conta_id = $('#conta_id').val();
        console.log("Conta escolhida " + conta_id)
        $.getJSON('ajax-buscar-movimentos.php?conta_id=' + conta_id, function (dados) {
            if (dados.length > 0) {
                console.log(dados)
                var option = '<option value="0">[ SELECIONE A CONTA ]</option>';
                $.each(dados, function (i, obj) {
                    option += '<option value="' + obj.ID + '"  > ' + obj.numero_conta + ' -  Saldo R$ 500,00 ' + ' </option>';
                })
            } else {
                alert("nenhuma conta foi encontrada para o cliente selecionado !!!");
                $('#conta_id').html("").show();
            }
            $('#conta_id').html(option).show();
        });
    });
});





