<?php
require_once('conexao.php');

class Previsao
{
    private $conn;

    public function __construct()
    {
        $dataBase = new dataBase();
        $this->conn = $dataBase->dbConnection();
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    public function getDisciplina($idturma)
    {
        try {
            $sql = "SELECT iddisciplina FROM turma as t
                where t.idturma = :idturma";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idturma', $idturma);
            $stmt->execute();

            // Verificar se a consulta foi bem-sucedida
            if ($stmt->rowCount() > 0) {
                $disciplina = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verificar se $disciplina['iddisciplina'] está definido antes de retornar
                return isset($disciplina['iddisciplina']) ? $disciplina['iddisciplina'] : null;
            } else {
                // Tratar o caso em que não há resultados
                return null;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            // Tratar exceção conforme necessário
            return null;
        }
    }

    public function getAllNotas($iddisciplina)
    {
        try {
            $sql = "SELECT nota FROM desempenho_aluno_turma as dat
                inner join turma as t on dat.idturma = t.idturma
                join disciplina as d on t.iddisciplina = d.iddisciplina
                where d.iddisciplina = :iddisciplina and t.tipoDeTurma = 'F'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':iddisciplina', $iddisciplina);
            $stmt->execute();
            $NotasDaTurma = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $valores = array_map(function ($item) {
                return floatval($item['nota']);
            }, $NotasDaTurma);
            // Retornar o array de valores
            return $valores;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAllFaltas($iddisciplina)
    {
        try {
            $sql = "SELECT falta FROM desempenho_aluno_turma as dat
                inner join turma as t on dat.idturma = t.idturma
                join disciplina as d on t.iddisciplina = d.iddisciplina
                where d.iddisciplina = :iddisciplina and t.tipoDeTurma = 'F'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':iddisciplina', $iddisciplina);
            $stmt->execute();
            $FaltaDaTurma = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $valores = array_map(function ($item) {
                return floatval($item['falta']);
            }, $FaltaDaTurma);
            // Retornar o array de valores
            return $valores;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }




    public function getFaltasNaTurma($idturma)
    {
        try {
            $sql = "SELECT falta FROM desempenho_aluno_turma
                where idturma = :idturma";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idturma', $idturma);
            $stmt->execute();
            $FaltaDaTurma = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $faltas = array_map(function ($item) {
                return $item["falta"];
            }, $FaltaDaTurma);
            return $faltas;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Função para ajustar um modelo de regressão linear
    public static function ajustarRegressaoLinear($faltas, $notas)
    {
        $quantidadeDeFaltas = count($faltas);
        // Calcular as somas necessárias
        $somaFaltas = array_sum($faltas);
        $somaFaltasQuadrado = array_sum(array_map(function ($x) {
            return $x * $x;
        }, $faltas));
        $somaNotas = array_sum($notas);
        $somaProdutos = array_sum(array_map(function ($x, $y) {
            return $x * $y;
        }, $faltas, $notas));
        // Calcular os coeficientes da regressão linear (m e b)
        $m = ($quantidadeDeFaltas * $somaProdutos - $somaFaltas * $somaNotas) / ($quantidadeDeFaltas * $somaFaltasQuadrado - pow($somaFaltas, 2));
        $b = ($somaNotas - $m * $somaFaltas) / $quantidadeDeFaltas;

        return ['m' => $m, 'b' => $b];
    }


    public function preverNotas($idturma)
    {
        $iddisciplina = $this->getDisciplina($idturma);
        $faltasParaPrever = $this->getFaltasNaTurma($idturma);
        $notas = $this->getAllNotas($iddisciplina);
        $faltas = $this->getAllFaltas($iddisciplina);
        $modelo = $this->ajustarRegressaoLinear($faltas, $notas);

        foreach ($faltasParaPrever as $falta) {
            $previsaoNotas = $modelo['m'] * $falta + $modelo['b'];


            $this->inserirPrevisaoNoBanco($idturma, $falta, $previsaoNotas);
        }
    }

    private function inserirPrevisaoNoBanco($idturma, $falta, $previsaoNotas)
    {
        try {

            $sql = "UPDATE desempenho_aluno_turma
            SET previsoes = CASE
                               WHEN :previsaoNotas < 0 THEN 0
                               ELSE :previsaoNotas
                            END
            WHERE idturma = :idturma AND falta = :falta";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idturma', $idturma);
            $stmt->bindParam(':falta', $falta);
            $stmt->bindParam(':previsaoNotas', $previsaoNotas);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function redirect($url)
    {
        header("Location: $url");
    }
}
