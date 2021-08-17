<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conta
 *
 * @author PauloCeami
 */


class Conta {

    private $id;
    private $numero_conta;
    private $pessoa_id;

    public function getId() {
        return $this->id;
    }

    public function getNumero_conta() {
        return $this->numero_conta;
    }

    public function getPessoa_id() {
        return $this->pessoa_id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNumero_conta($numero_conta): void {
        $this->numero_conta = $numero_conta;
    }

    public function setPessoa_id($pessoa_id): void {
        $this->pessoa_id = $pessoa_id;
    }

}
