<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PessoaController
 *
 * @author PauloCeami
 */


class PessoaController {

    function __construct() {
        
    }

    public function cSalvarPessoa() {
        $pessoa = new Pessoa();
        // salva o nome com letras iniciais maiusculas
        $pessoa->setNome(ucwords($_POST["nome"]));
        #retirar char do input cpf
        $pessoa->setCpf(str_replace(array('.', '-'), '', $_POST["cpf"]));
        $pessoa->setEndereco(strtolower($_POST["endereco"]));
        return PessoaModel::getInstance()->mSalvarPessoa($pessoa);
    }

    public function cAlterarPessoa() {
        $pessoa = new Pessoa();
        $pessoa->setId($_POST["id"]);
        // salva o nome com letras iniciais maiusculas
        $pessoa->setNome(ucwords($_POST["nome"]));
        #retirar char do input cpf
        $pessoa->setCpf(str_replace(array('.', '-'), '', $_POST["cpf"]));
        $pessoa->setEndereco(strtolower($_POST["endereco"]));
        return PessoaModel::getInstance()->mAlterarPessoa($pessoa);
    }

    public function cBuscarPessoaByCodigo() {
        return PessoaModel::getInstance()->mBuscarPessoaByCodigo($_GET["id"]);
    }

    public function getAll() {
        return PessoaModel::getInstance()->getAll();
    }

    public function cRemoverPessoa() {
        return PessoaModel::getInstance()->mRemoverPessoa($_GET["id"]);
    }

}
