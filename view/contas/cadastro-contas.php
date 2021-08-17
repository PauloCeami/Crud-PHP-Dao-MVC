<?php
error_reporting(0);

require_once '../../Utils/Util.php';
require_once '../../model/Pessoa.php';
require_once '../../model/ConPDO.php';
require_once '../../controller/PessoaController.php';
require_once '../../model/PessoaModel.php';

require_once '../../model/Conta.php';
require_once '../../controller/ContaController.php';
require_once '../../model/ContaModel.php';

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
$contas = $contaController->getAll();

if ($codigo > 0) {
    $conta = $contaController->cBuscarContaByCodigo();
}

if ($acao != "") {

    if ($acao == "incluir") {

        $c = new Conta();
        $c = ContaModel::getInstance()->mBuscarContaByNumeroConta(trim($_POST["numero_conta"]));

        if (is_null($c->getId())) {
            $contaController->cSalvarConta();
            header("Location:cadastro-contas.php");
        } else {
            echo "<script>alert('O numero desta conta já existe !!')</script>";
            echo "<script>window.history.go(-1);</script>";
        }
    }

    if ($acao == "alterar") {

        $c = new Conta();
        $c = ContaModel::getInstance()->mBuscarContaByNumeroConta(trim($_POST["numero_conta"]));

        if (is_null($c->getId())) {
            $contaController->cAlterarConta();
            header("Location:cadastro-contas.php");
        } else {
            echo "<script>alert('O numero desta conta já existe !!')</script>";
            echo "<script>window.history.go(-1);</script>";
        }
    }

    if ($acao == "excluir") {
        
        //ALTER TABLE `movimentacao` ADD CONSTRAINT `fk_conta` FOREIGN KEY ( `conta_id` ) REFERENCES `conta` ( `id` );
        $contaController->cRemoverConta();
        header("Location:cadastro-contas.php");
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
        <title>Sistema Financeiro PHP Crud Dao</title>
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
            <h1 class="display-4">Cadastro de Contas</h1>
            <p class="lead">Sistema Financeiro</p>
            <p class="lead">Paulo Roberto dos Santos</p>
        </div>

        <div class="container">
            <div class="row">
                <form class="table table-striped" method="POST" action="http://localhost/Crud-PHP-Dao-MVC/view/contas/cadastro-contas.php">

                    <input type="hidden" required name="acao" id="acao" value="<?php echo ($codigo > 0) ? "alterar" : "incluir" ?>" />
                    <input type="hidden"  name="id" id="id" value="<?= $conta->getId() ?>" />                           

                    <div class="form-group">
                        <label class="control-label" ><a style="text-decoration: underline" href="http://localhost/Crud-PHP-Dao-MVC">add pessoa</a></label>  
                        <select   class="form-control select2"  id="pessoa_id" name="pessoa_id">
                            <option value="0">[ SELECIONE UMA PESSOA ]</option>
                            <?php foreach ($pessoas as $p): ?>
                                <option  <?php echo ($conta->getPessoa_id() == $p->getId()) ? "selected" : "" ?>     value="<?= $p->getId() ?>"> <?= $p->getNome() . ' - ' . Util::formatCPF($p->getCpf()) ?></option>
                            <?php endforeach; ?>
                        </select>                                    
                    </div>


                    <div class="form-group">
                        <label for="numero_conta">Número da Conta.:</label>
                        <input required type="text" maxlength="10" class="form-control" name="numero_conta" value="<?= $conta->getNumero_conta() ?>" id="numero_conta" placeholder="número da conta">
                    </div>


                    <button type="submit" onClick="return pessoaid()" class="<?= ($codigo > 0) ? "btn btn-warning" : "btn btn-primary" ?>"><?= ($codigo > 0) ? "Alterar" : "Salvar" ?></button>
                </form>
            </div>
        </div>


        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Numero da conta</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = count($contas);
                    if ($count > 0):
                        foreach ($contas as $c):
                            ?>
                            <tr>
                                <th><?php echo $c->nome ?></th>
                                <td><?php echo Util::formatCPF($c->cpf) ?></td>
                                <td><?php echo $c->numero_conta ?></td>
                                <td>
                                    <a class="btn btn-warning" href="cadastro-contas.php?id=<?php echo $c->id ?>">Editar</a>
                                    <a class="btn btn-danger" title="Excluir"  href="javascript:if(confirm('Deseja excluir a conta da pessoa <?php echo $c->nome ?> ?')) {location='cadastro-contas.php?acao=excluir&id=<?php echo $c->id ?> ';}"><i class="fa fa-trash" aria-hidden="true"></i>
                                        Remover</a>
                                </td>
                            </tr>

                            <?php
                        endforeach;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>

        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <div class="row">
            </div>
        </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>

                        $('#pessoa_id').change(function () {
                            var value = $(this).val();
                            if (value == '0') {
                                alert('[ SELECIONE UMA PESSOA ]');
                            }
                        });


                        function pessoaid() {
                            var x;
                            x = document.getElementById("pessoa_id").value;
                            if ((x == null) || (x == "0")) {
                                alert('[ SELECIONE UMA PESSOA ]');
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


                        //Mascara CPF
                        $(document).ready(function () {
                            $('#cpf').mask('999.999.999-99');
                        });
    </script>
</body>
</html>
