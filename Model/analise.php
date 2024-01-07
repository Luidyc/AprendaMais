<?php
    require_once('conexao.php');

    class Analise{
        private $conn;

        public function __construct(){
            $dataBase = new dataBase();
            $this->conn = $dataBase->dbConnection();
        }

        public function runQuery($sql){
            $stmt = $this->conn->prepare($sql);
            return $stmt;
        }

        public function getNotas($idturma){
            try{
                $sql = "SELECT nota FROM desempenho_aluno_turma
                where idturma = :idturma";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':idturma', $idturma);
                $stmt->execute();
                $NotasDaTurma = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $Notas = array_map(function($item) {
                    return $item["nota"];
                }, $NotasDaTurma);
                return $Notas;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function getFaltas($idturma){
            try{
                $sql = "SELECT falta FROM desempenho_aluno_turma
                where idturma = :idturma";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':idturma', $idturma);
                $stmt->execute();
                $FaltaDaTurma = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $faltas = array_map(function($item) {
                    return $item["falta"];
                }, $FaltaDaTurma);
                return $faltas;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }


        // Função para calcular a média de um array de números
        public function calcularMedia($array) {
            $soma = array_sum($array);
            return $soma / count($array);
        }

        // Função para calcular o desvio padrão de um array de números
        public function calcularDesvioPadrao($array) {
            $media = self::calcularMedia($array);
            $somaDiferencasAoQuadrado = 0;
            foreach ($array as $num) {
                $somaDiferencasAoQuadrado += pow($num - $media, 2);
            }
            $variancia = $somaDiferencasAoQuadrado / count($array);
            return sqrt($variancia);
        }

        // Função para calcular o coeficiente de correlação de Pearson (r)
        public function calcularCorrelacao($idturma) {
            $Notas = self::getNotas($idturma);
            $Faltas = self::getFaltas($idturma);
            $mediaDeNotas = self::calcularMedia($Notas);
            $mediaDeFaltas = self::calcularMedia($Faltas);
            $desvioPadraoDeNotas = self::calcularDesvioPadrao($Notas);
            $desvioPadraoDeFaltas = self::calcularDesvioPadrao($Faltas);
            $somaProdutosDesvios = 0;
            for ($i = 0; $i < count($Notas); $i++) {
            $somaProdutosDesvios += (($Notas[$i] - $mediaDeNotas) / $desvioPadraoDeNotas) 
            * (($Faltas[$i] - $mediaDeFaltas) / $desvioPadraoDeFaltas);
            }
            $correlacao = $somaProdutosDesvios / count($Notas);
            return $correlacao;
        }

        public function insertPercentual($idturma){
            try{
                $correlacao = self::calcularCorrelacao($idturma);
                $correlacao = number_format($correlacao,2);
                $sql = "UPDATE TURMA 
                SET percentualregresso = :percentualregresso
                WHERE idturma = :idturma";               
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':percentualregresso', $correlacao);
                $stmt->bindParam(':idturma', $idturma);
                $stmt->execute();
                return $stmt;

            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }


        public function redirect($url){
            header("Location: $url");
        }        
    }
?>