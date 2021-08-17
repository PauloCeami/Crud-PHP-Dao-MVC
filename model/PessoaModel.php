<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PessoaModel
 *
 * @author PauloCeami
 */


class PessoaModel {

    public static $instance;

    public function __construct() {
        
    }

    static public function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new PessoaModel();
        return self::$instance;
    }

    public function mSalvarPessoa(Pessoa $pessoa) {
        try {
            $sql = "INSERT INTO pessoa (nome, cpf, endereco) values (?,?,?)";
            $statement_sql = ConPDO::getInstance()->prepare($sql);
            $statement_sql->bindValue(1, $pessoa->getNome());
            $statement_sql->bindValue(2, $pessoa->getCpf());
            $statement_sql->bindValue(3, $pessoa->getEndereco());
            $statement_sql->execute();
            return ConPDO::getInstance()->lastInsertId();
        } catch (PDOException $e) {
            print "Erro ao salvar pessoa :: " . $e->getMessage();
        }
    }

    public function mAlterarPessoa(Pessoa $pessoa) {
        $sql = "UPDATE pessoa SET id=?, nome=?, cpf=?, endereco=? WHERE id=?";
        $stmt = ConPDO::getInstance()->prepare($sql);
        $stmt->execute([$pessoa->getId(), $pessoa->getNome(), $pessoa->getCpf(), $pessoa->getEndereco(), $pessoa->getId()]);
    }

    public function mRemoverPessoa($id) {
        try {
            $sql = "DELETE FROM pessoa WHERE id=:id";
            $statement_sql = ConPDO::getInstance()->prepare($sql);
            $statement_sql->bindValue(":id", $id);
            return $statement_sql->execute();
        } catch (PDOException $e) {
            print "Erro em mRemoverPessoa :: " . $e->getMessage();
        }
    }

    public function mBuscarPessoaByCodigo($id) {
        try {
            $sql = "SELECT * FROM pessoa where id= :id";
            $statement_sql = ConPDO::getInstance()->prepare($sql);
            $statement_sql->bindValue(":id", $id);
            $statement_sql->execute();
            return $this->popularPessoa($statement_sql->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            print "Erro em mBuscarPessoaByCodigo :: " . $e->getMessage();
        }
    }

    public function popularPessoa($linha) {
        $pessoa = new Pessoa();
        $pessoa->setId($linha["id"]);
        $pessoa->setNome($linha ["nome"]);
        $pessoa->setCpf($linha["cpf"]);
        $pessoa->setEndereco($linha["endereco"]);
        return $pessoa;
    }

    public function getAll() {
        try {
            $sql = "SELECT * FROM pessoa";
            $statement_sql = ConPDO::getInstance()->prepare($sql);
            $statement_sql->execute();
            return $this->fechPessoa($statement_sql);
        } catch (PDOException $e) {
            print "Erro em getAll Pessoa :: " . $e->getMessage();
        }
    }

    private function fechPessoa($statement_sql) {
        $results = array();
        if ($statement_sql) {
            while ($linha = $statement_sql->fetch(PDO::FETCH_OBJ)) {
                $pessoa = new Pessoa();
                $pessoa->setId($linha->id);
                $pessoa->setNome($linha->nome);
                $pessoa->setCpf($linha->cpf);
                $pessoa->setEndereco($linha->endereco);
                $results [] = $pessoa;
            }
        }
        return $results;
    }

}
