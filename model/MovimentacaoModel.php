<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MovimentacaoModel
 *
 * @author PauloCeami
 */



class MovimentacaoModel {

    public static $instance;

    public function __construct() {
        
    }

    static public function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new MovimentacaoModel();
        return self::$instance;
    }

    public function mSalvarMovimento(Movimentacao $movimento) {
        try {
            $sql = "INSERT INTO movimentacao (pessoa_id,conta_id,tipo_movimento,data_hora,valor) values (?,?,?,?,?)";
            $statement_sql = ConPDO::getInstance()->prepare($sql);
            $statement_sql->bindValue(1, $movimento->getPessoa_id());
            $statement_sql->bindValue(2, $movimento->getConta_id());
            $statement_sql->bindValue(3, $movimento->getTipo_movimento());
            $statement_sql->bindValue(4, $movimento->getData_hora());
            $statement_sql->bindValue(5, $movimento->getValor());
            $statement_sql->execute();
            return ConPDO::getInstance()->lastInsertId();
        } catch (PDOException $e) {
            print "Erro ao mSalvarMovimento :: " . $e->getMessage();
        }
    }

    public function mBuscar_movimento_ajax($conta_id) {
        try {
            $sql = "SELECT *,DATE_FORMAT(data_hora,'%d/%m/%Y %Hh%i') AS datahora from movimentacao WHERE conta_id=?";
            $stmt = ConPDO::getInstance()->prepare($sql);
            $stmt->bindValue(1, $conta_id);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            print "Erro em mBuscar_movimento_ajax " . $e->getMessage();
        }
    }

    public function getSaldo($pessoa_id) {
        try {
            $sql = "SELECT a.pessoa_id, 
                    a.positivos, 
                    a.negativos,
                    (a.positivos - abs(a.negativos)) diferenca
             FROM (
             SELECT pessoa_id,  
                 sum(CASE WHEN valor > 0 THEN VALOR ELSE 0 END) positivos,
                 sum(CASE WHEN valor < 0 THEN VALOR ELSE 0 END) negativos
             FROM movimentacao where pessoa_id =:pessoa_id GROUP BY pessoa_id) as a";
            $statement_sql = ConPDO::getInstance()->prepare($sql);
            $statement_sql->bindValue(":pessoa_id", $pessoa_id);
            $statement_sql->execute();
            return $this->getData($statement_sql->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            print "Erro em getSaldo :: " . $e->getMessage();
        }
    }

    public function getData($linha) {
        $data = new stdClass();
        $data->pessoa_id = $linha["pessoa_id"];
        $data->positivos = $linha["positivos"];
        $data->negativos = $linha["negativos"];
        $data->diferenca = $linha["diferenca"];
        return $data;
    }

}
