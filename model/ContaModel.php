<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContaModel
 *
 * @author PauloCeami
 */

class ContaModel {

    public static $instance;

    public function __construct() {
        
    }

    static public function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new ContaModel();
        return self::$instance;
    }

    public function mSalvarConta(Conta $conta) {
        try {
            $sql = "INSERT INTO conta (numero_conta,pessoa_id) values (?,?)";
            $statement_sql = ConPDO::getInstance()->prepare($sql);
            $statement_sql->bindValue(1, $conta->getNumero_conta());
            $statement_sql->bindValue(2, $conta->getPessoa_id());
            $statement_sql->execute();
            return ConPDO::getInstance()->lastInsertId();
        } catch (PDOException $e) {
            print "Erro ao salvar conta :: " . $e->getMessage();
        }
    }

    public function mAlterarConta(Conta $conta) {
        $sql = "UPDATE conta SET id=?, numero_conta=?, pessoa_id=? WHERE id=?";
        $stmt = ConPDO::getInstance()->prepare($sql);
        $stmt->execute([$conta->getId(), $conta->getNumero_conta(), $conta->getPessoa_id(), $conta->getId()]);
    }

    public function mRemoverConta($id) {
        try {
            $sql = "DELETE FROM conta WHERE id=:id";
            $statement_sql = ConPDO::getInstance()->prepare($sql);
            $statement_sql->bindValue(":id", $id);
            return $statement_sql->execute();
        } catch (PDOException $e) {
            print "Erro em mRemoverConta :: " . $e->getMessage();
        }
    }

    public function mBuscarContaByCodigo($id) {
        try {
            $sql = "SELECT * FROM conta where id=:id";
            $statement_sql = ConPDO::getInstance()->prepare($sql);
            $statement_sql->bindValue(":id", $id);
            $statement_sql->execute();
            return $this->popularconta($statement_sql->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            print "Erro em mBuscarContaByCodigo :: " . $e->getMessage();
        }
    }

    public function mBuscarContaByNumeroConta($numero_conta) {
        try {
            $sql = "SELECT * FROM conta where numero_conta= :numero_conta";
            $statement_sql = ConPDO::getInstance()->prepare($sql);
            $statement_sql->bindValue(":numero_conta", $numero_conta);
            $statement_sql->execute();
            return $this->popularconta($statement_sql->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            print "Erro em mBuscarContaByNumeroConta :: " . $e->getMessage();
        }
    }

    public function popularconta($linha) {
        $conta = new Conta();
        $conta->setId($linha["id"]);
        $conta->setNumero_conta($linha ["numero_conta"]);
        $conta->setPessoa_id($linha["pessoa_id"]);
        return $conta;
    }

    public function getAll() {
        try {
            $sql = "SELECT 
                    c.id,
                    p.nome,
                    p.cpf,
                    c.numero_conta
                    FROM conta c 
                    LEFT OUTER JOIN pessoa p 
                    ON c.pessoa_id = p.id";
            $statement_sql = ConPDO::getInstance()->prepare($sql);
            $statement_sql->execute();
            return $this->fechConta($statement_sql);
        } catch (PDOException $e) {
            print "Erro em getAll Conta :: " . $e->getMessage();
        }
    }

    private function fechConta($statement_sql) {
        $results = array();
        if ($statement_sql) {
            while ($linha = $statement_sql->fetch(PDO::FETCH_OBJ)) {
                $conta = new stdClass();
                $conta->id = $linha->id;
                $conta->nome = $linha->nome;
                $conta->cpf = $linha->cpf;
                $conta->numero_conta = $linha->numero_conta;
                $results [] = $conta;
            }
        }
        return $results;
    }

    public function mBuscar_contas_combobox_ajax($pessoa_id) {
        try {
            $sql = 'SELECT 
                    m.pessoa_id as pessoa,
                    c.numero_conta,
                    c.id,
                    m.conta_id as conta,
                    m.data_hora as data,
                    m.tipo_movimento as tipo,
                    m.valor as valor
                    FROM conta c
                    LEFT OUTER JOIN pessoa p
                    ON c.pessoa_id = p.id
                    LEFT OUTER JOIN movimentacao m
                    ON m.conta_id = c.id
                    WHERE c.pessoa_id=?';
            $stmt = ConPDO::getInstance()->prepare($sql);
            $stmt->bindValue(1, $pessoa_id);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            print "Erro em mBuscar_contas_combobox_ajax " . $e->getMessage();
        }
    }

}
