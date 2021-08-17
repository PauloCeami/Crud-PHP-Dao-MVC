<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContaController
 *
 * @author PauloCeami
 */


class ContaController {

    function __construct() {
        
    }

    public function cSalvarConta() {
        $conta = new Conta();
        $conta->setPessoa_id($_POST["pessoa_id"]);
        $conta->setNumero_conta($_POST["numero_conta"]);
        return ContaModel::getInstance()->mSalvarConta($conta);
    }

    public function cAlterarConta() {
        $conta = new Conta();
        $conta->setId($_POST["id"]);
        $conta->setPessoa_id($_POST["pessoa_id"]);
        $conta->setNumero_conta($_POST["numero_conta"]);
        return ContaModel::getInstance()->mAlterarConta($conta);
    }

    public function cBuscarContaByCodigo() {
        return ContaModel::getInstance()->mBuscarContaByCodigo($_GET["id"]);
    }

    public function getAll() {
        return ContaModel::getInstance()->getAll();
    }

    public function cRemoverConta() {
        return ContaModel::getInstance()->mRemoverConta($_GET["id"]);
    }

    public function cBuscar_contas_combobox_ajax($pessoa_id) {
        return ContaModel::getInstance()->mBuscar_contas_combobox_ajax($pessoa_id);
    }

}
