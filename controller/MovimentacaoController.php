<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MovimentacaoController
 *
 * @author PauloCeami
 */


class MovimentacaoController {

    function __construct() {
        
    }

    public function cSalvarMovimento() {

        date_default_timezone_set('America/Sao_Paulo');
        $tipo = $_POST["tipo_movimento"];
        $valor = $_POST['valor'];
        if ($tipo === "RETIRAR") {
            $valor = -$_POST['valor'];
        }
        $mov = new Movimentacao();
        $mov->setPessoa_id($_POST["pessoa_id"]);
        $mov->setConta_id($_POST["conta_id"]);
        $mov->setTipo_movimento($_POST["tipo_movimento"]);
        $mov->setData_hora(date('Y-m-d H:i:s'));
        $mov->setValor($valor);
        return MovimentacaoModel::getInstance()->mSalvarMovimento($mov);
    }
    
    public function getSaldo($pessoa_id) {
        return MovimentacaoModel::getInstance()->getSaldo($pessoa_id); ;
    }

    public function cBuscar_movimento_ajax($conta_id) {
        return MovimentacaoModel::getInstance()->mBuscar_movimento_ajax($conta_id);
    }

}
