<?php

require_once '../../Utils/Util.php';
require_once '../../model/ConPDO.php';
require_once '../../model/Movimentacao.php';
require_once '../../controller/MovimentacaoController.php';
require_once '../../model/MovimentacaoModel.php';
$conta_id = isset($_REQUEST["conta_id"]) ? $_REQUEST["conta_id"] : 0;
$moviController = new MovimentacaoController();
$movimento = $moviController->cBuscar_movimento_ajax(trim($conta_id));
echo $movimento;
