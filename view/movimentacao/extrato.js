$(document).ready(function () {
    $('#conta_id').change(function (e) {
        var conta_id = $('#conta_id').val();
        console.log('conta id ::: ' + conta_id)
        var html = '';
        $('#tabela').empty();
        $('#tabela').html('');
        $('#saldo').text('Saldo R$ 0,00');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'ajax-buscar-movimentos.php',
            data: {conta_id: conta_id},
            success: function (retorno) {
                console.log(retorno)
                if (retorno != 0) {
                    var valPos = 0;
                    var valNeg = 0;

                    for (var i = 0; retorno.length > i; i++) {

                        var num = parseFloat(retorno[i].valor);

                        if (negative(num)) {
                            var color = 'color:red';
                            valNeg += num;
                        } else {
                            var color = '';
                            valPos += num;
                        }

                        var tot = valPos - (-valNeg);
                        if (tot < 0) {
                            tot = 0;
                        }

                        html += "<tr>";
                        html += "<td>" + retorno[i].datahora + "</td>";
                        html += "<td style='" + color + "'>" + retorno[i].valor + "</td>";
                        html += "</tr>";
                        $('#tabela').html(html);
                    }
                    $('#saldo').text("Saldo R$: " + tot.toFixed(2));
                }
            }
        });

    });

    function negative(number) {
        return !Object.is(Math.abs(number), +number);
    }
});





