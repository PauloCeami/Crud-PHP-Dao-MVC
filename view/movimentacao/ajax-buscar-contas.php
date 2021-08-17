<?php

require_once '../../Utils/Util.php';
require_once '../../model/ConPDO.php';
require_once '../../model/Conta.php';
require_once '../../controller/ContaController.php';
require_once '../../model/ContaModel.php';

$pessoa_id = isset($_GET["pessoa_id"]) ? $_GET["pessoa_id"] : 0;
$contaController = new ContaController();
$pessoa = $contaController->cBuscar_contas_combobox_ajax(trim($pessoa_id));
echo $pessoa;