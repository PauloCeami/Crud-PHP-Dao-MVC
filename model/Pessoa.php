<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pessoa
 *
 * @author PauloCeami
 */

class Pessoa {

    private $id;
    private $nome;
    private $cpf;
    private $endereco;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setCpf($cpf): void {
        $this->cpf = $cpf;
    }

    public function setEndereco($endereco): void {
        $this->endereco = $endereco;
    }

}
