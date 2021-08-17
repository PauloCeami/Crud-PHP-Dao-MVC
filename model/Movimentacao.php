<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Movimentacao
 *
 * @author PauloCeami
 */



class Movimentacao {

    private $id;
    private $pessoa_id;
    private $conta_id;
    private $tipo_movimento;
    private $data_hora;
    private $valor;

    public function getId() {
        return $this->id;
    }

    public function getPessoa_id() {
        return $this->pessoa_id;
    }

    public function getConta_id() {
        return $this->conta_id;
    }

    public function getTipo_movimento() {
        return $this->tipo_movimento;
    }

    public function getData_hora() {
        return $this->data_hora;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setPessoa_id($pessoa_id): void {
        $this->pessoa_id = $pessoa_id;
    }

    public function setConta_id($conta_id): void {
        $this->conta_id = $conta_id;
    }

    public function setTipo_movimento($tipo_movimento): void {
        $this->tipo_movimento = $tipo_movimento;
    }

    public function setData_hora($data_hora): void {
        $this->data_hora = $data_hora;
    }

    public function setValor($valor): void {
        $this->valor = $valor;
    }

}
