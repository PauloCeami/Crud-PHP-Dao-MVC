<?php
error_reporting(0);

require_once './model/ConPDO.php';
require_once './controller/PessoaController.php';
require_once './model/Pessoa.php';
require_once './model/PessoaModel.php';
require_once './Utils/Util.php';

$pessoa = new Pessoa();
$pessoaController = new PessoaController();
$pessoaModel = new PessoaModel();

$pessoas = new Pessoa();
$pessoas = $pessoaController->getAll();

$acao = (isset($_POST["acao"])) ? $_POST["acao"] : ((isset($_GET["acao"])) ? $_GET["acao"] : "");
$codigo = (isset($_POST["id"])) ? $_POST["id"] : ((isset($_GET["id"])) ? $_GET["id"] : 0);

if ($codigo > 0) {
    $pessoa = $pessoaController->cBuscarPessoaByCodigo();
}

if ($acao != "") {

    if ($acao == "incluir") {
        $pessoaController->cSalvarPessoa();
        header("Location:index.php");
    }

    if ($acao == "alterar") {
        $pessoaController->cAlterarPessoa();
        header("Location:index.php");
    }

    if ($acao == "excluir") {
        $pessoaController->cRemoverPessoa();
        header("Location:index.php");
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
            <?php
            include_once './view/menu.php';
            ?>
        </div>

        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Cadastro de Pessoa</h1>
            <p class="lead">Sistema Financeiro</p>
            <p class="lead">Paulo Roberto dos Santos  </p>
        </div>

        <div class="container">
            <div class="row">
                <form class="table table-striped" method="POST" action="http://localhost/Crud-PHP-Dao-MVC/index.php">

                    <input type="hidden" required name="acao" id="acao" value="<?php echo ($codigo > 0) ? "alterar" : "incluir" ?>" />
                    <input type="hidden"  name="id" id="id" value="<?= $pessoa->getId() ?>" />                           

                    <div class="form-group">
                        <label for="pessoanome">Nome.:</label>
                        <input required type="text" class="form-control" name="nome" value="<?= $pessoa->getNome() ?>" id="nome" aria-describedby="nome" placeholder="nome da pessoa">
                    </div>

                    <div class="form-group">
                        <label for="pessoacpf">CPF.:</label>
                        <input required type="text" class="form-control" name="cpf" value="<?= $pessoa->getCpf() ?>" id="cpf" placeholder="cpf da pessoa">
                    </div>

                    <div class="form-group">
                        <label for="pessoaendereco">Endereço.:</label>
                        <input required type="text" class="form-control" name="endereco" value="<?= $pessoa->getEndereco() ?>" id="endereco" placeholder="endereço da pessoa">
                    </div>

                    <button type="submit" class="<?= ($codigo > 0) ? "btn btn-warning" : "btn btn-primary" ?>"><?= ($codigo > 0) ? "Alterar" : "Salvar" ?></button>
                </form>
            </div>
        </div>


        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = count($pessoas);
                    if ($count > 0):
                        foreach ($pessoas as $pes):
                            ?>
                            <tr>
                                <th><?php echo $pes->getNome() ?></th>
                                <td><?php echo Util::formatCPF($pes->getCpf()) ?></td>
                                <td><?php echo $pes->getEndereco() ?></td>
                                <td>
                                    <a class="btn btn-warning" href="index.php?id=<?php echo $pes->getId() ?>">Editar</a>
                                    <a class="btn btn-danger" title="Excluir"  href="javascript:if(confirm('Deseja excluir o cliente <?php echo $pes->getNome() ?> ?')) {location='index.php?acao=excluir&id=<?php echo $pes->getId() ?> ';}"><i class="fa fa-trash" aria-hidden="true"></i>
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

        $('#nome').keypress(function (e) {
            var keyCode = (e.keyCode ? e.keyCode : e.which); // Variar a chamada do keyCode de acordo com o ambiente.
            if (keyCode > 47 && keyCode < 58) {
                e.preventDefault();
            }
        });




        //Mascara CPF
        $(document).ready(function () {
            $('#cpf').mask('999.999.999-99');
        });
    </script>
</body>
</html>
