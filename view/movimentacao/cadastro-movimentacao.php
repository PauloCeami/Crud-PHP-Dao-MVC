<?php
error_reporting(0);

require_once '../../Utils/Util.php';
require_once '../../model/ConPDO.php';

require_once '../../model/Pessoa.php';
require_once '../../controller/PessoaController.php';
require_once '../../model/PessoaModel.php';

require_once '../../model/Conta.php';
require_once '../../controller/ContaController.php';
require_once '../../model/ContaModel.php';

require_once '../../model/Movimentacao.php';
require_once '../../controller/MovimentacaoController.php';
require_once '../../model/MovimentacaoModel.php';

$acao = (isset($_POST["acao"])) ? $_POST["acao"] : ((isset($_GET["acao"])) ? $_GET["acao"] : "");
$codigo = (isset($_POST["id"])) ? $_POST["id"] : ((isset($_GET["id"])) ? $_GET["id"] : 0);

//******************************************* PESSOA 
$pessoa = new Pessoa();
$pessoaController = new PessoaController();
$pessoaModel = new PessoaModel();

$pessoas = new Pessoa();
$pessoas = $pessoaController->getAll();

//******************************************* CONTA
$conta = new Conta();
$contaController = new ContaController();
$contaModel = new ContaModel();

$contas = new Conta();
$contas = $contaController->getAll();  /// trazer em select com joins
//var_dump($contas);
//exit();
//**************************************** MOVIMENTACAO
$movimentacao = new Movimentacao();
$moviController = new MovimentacaoController();

if ($acao != "") {

    if ($acao == "incluir") {

        // verificar se o cliente possui saldo
        $data = $moviController->getSaldo($_POST["pessoa_id"]);

        $tipo = $_POST["tipo_movimento"];
        $saldo = $data->diferenca;

        if (($saldo <= 0) && ($tipo === "RETIRAR")) {
            echo "<script>alert('Cliente sem saldo para realizar saque !!! ')</script>";
            echo "<script>window.history.go(-1);</script>";
        } else {
            $moviController->cSalvarMovimento();
            header("Location:cadastro-movimentacao.php");
        }
    }
}
?>


<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
        <title>Prova PHP IST</title>
        <!-- css bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- plugin js para mascara de CPF -->

        <style type="text/css">
            #nome{
                text-transform: capitalize;
            }
        </style>
    </head>

    <body>
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
            <nav class="my-2 my-md-0 mr-md-3">
                <?php
                include_once '../menu.php';
                ?>
            </nav>
        </div>

        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Cadastro de Movimentações</h1>
            <p class="lead">Sistema Financeiro</p>
            <p class="lead">Paulo Roberto dos Santos </p>
        </div>

        <div class="container">
            <div class="row">
                <form class="table table-striped" method="POST" action="http://localhost/ProvaPHPIST/view/movimentacao/cadastro-movimentacao.php">
                    <input type="hidden" required name="acao" id="acao" value="incluir" />

                    <div class="form-group">
                        <label class="control-label" >Pessoa</label>  
                        <select   class="form-control select2"  id="pessoa_id" name="pessoa_id">
                            <option value="0">[ SELECIONE UMA PESSOA ]</option>
                            <?php foreach ($pessoas as $p): ?>
                                <option  value="<?= $p->getId() ?>"> <?= $p->getId() . ' | ' . $p->getNome() . ' - ' . Util::formatCPF($p->getCpf()) ?></option>
                            <?php endforeach; ?>
                        </select>                                    
                    </div>


                    <div class="form-group">
                        <label class="control-label">Número da conta</label>  
                        <select class="form-control select2"  id="conta_id" name="conta_id">

                        </select>                                    
                    </div>


                    <div class="form-group">
                        <label for="valor">Valor.:</label>
                        <input required type="text"  class="form-control" name="valor" value="" id="valor" placeholder="valor R$ 0,00">
                    </div>


                    <div class="form-group">
                        <label class="control-label">Tipo Movimento.:</label>  
                        <select   class="form-control select2"  id="tipo_movimento" name="tipo_movimento">
                            <option value="DEPOSITAR">DEPOSITAR</option>
                            <option value="RETIRAR">RETIRAR</option>
                        </select>                                    
                    </div>
                    <button type="submit" onClick="return validar()" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>


        <div class="container">
            <h3>Extrato da Conta</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Data da transação</th>
                        <th scope="col">Valor</th>
                    </tr>
                </thead>
                <tbody id="tabela">

                </tbody>
            </table>
            <div id="saldo"></div>
        </div>

        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <div class="row">
            </div>
        </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
<!--    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
    <script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="ajax-buscar-contas.js"></script>
    <script type="text/javascript" src="extrato.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>

                        $('#pessoa_id').change(function () {
                            var value = $(this).val();
                            if (value == '0') {
                                alert('[ SELECIONE UMA PESSOA ]');
                            }
                        });


                        function validar() {

                            var c = document.getElementById("conta_id").value;
                            var p = document.getElementById("pessoa_id").value;
                            var v = document.getElementById("valor").value;

                            if ((p == null) || (p == "0")) {
                                alert('[ SELECIONE UMA PESSOA ]');
                                return false;
                            }

                            if ((c == null) || (c == "0")) {
                                alert('[ SELECIONE UMA CONTA ]');
                                return false;
                            }

                            if ((v == null) || (v == "0")) {
                                alert('INFORME UM VALOR PARA DEPOSITO OU SAQUE');
                                return false;
                            }

                        }



                        $('#numero_conta').keypress(function (e) {
                            var charCode = e.charCode ? e.charCode : e.keyCode;
                            if (charCode != 8 && charCode != 9) {
                                if (charCode < 48 || charCode > 57) {
                                    return false;
                                }
                            }
                        });


                        //Mascara valor
                        $(document).ready(function () {
                            $('#valor').mask("###0.00", {reverse: true});
                        });
    </script>
</body>
</html>
