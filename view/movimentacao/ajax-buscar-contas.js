$(document).ready(function () {
    $('#pessoa_id').change(function (e) {
        var pessoa_id = $('#pessoa_id').val();
        console.log("Pessoa escolhida " + pessoa_id)
        $.getJSON('ajax-buscar-contas.php?pessoa_id=' + pessoa_id, function (dados) {
            if (dados.length > 0) {
                console.log(dados)
                var valPos = 0;
                var valNeg = 0;
                var data = "";
                $.each(dados, function (i, obj) {

                    var num = parseFloat(obj.valor);

                    if (negative(num)) {
                        valNeg += num;
                    } else {
                        valPos += num;
                    }

                    var tot = valPos -(-valNeg);
                    if (tot < 0) {
                        tot = 0;
                    }

                    data = '<option value="' + obj.id + '">' + obj.numero_conta + ' | Saldo R$ ' + tot.toFixed(2) + ' </option>';
                })

                var option = '<option value="0">[ SELECIONE A CONTA ]</option>';
                option += data;

            } else {
                alert("nenhuma conta foi encontrada para o cliente selecionado !!!");
                $('#conta_id').html("").show();
            }
            $('#conta_id').html(option).show();
        });
    });


    function negative(number) {
        return !Object.is(Math.abs(number), +number);
    }
});





