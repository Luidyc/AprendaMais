<?php
    require_once('conexao.php');

    class Disciplina{
        private $conn;

        public function __construct(){
            $dataBase = new dataBase();
            $this->conn = $dataBase->dbConnection();
        }

        public function runQuery($sql){
            $stmt = $this->conn->prepare($sql);
            return $stmt;
        }


        public function getDisciplinaByid($id) {
            $query = "SELECT nome FROM disciplina WHERE iddisciplina = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getDisciplinaByCurso($idCurso) {
            $query = "SELECT nome FROM disciplina 
            inner join curso on idcurso = :idcurso";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function insert($nome,$idcurso){
            try{
                $sql = "INSERT INTO disciplina(nome, idcurso)
                VALUES(:nome, :idcurso)";                

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':idcurso', $idcurso);
                $stmt->execute();
                return $stmt;

            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function deletar($iddisciplina){
            try{
                $sql = "DELETE FROM disciplina where iddisciplina = :iddisciplina";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':iddisciplina', $iddisciplina);
                $stmt->execute();
                return $stmt;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function editar($nome, $iddisciplina){
            try{
                $sql = "UPDATE disciplina SET
                        nome = :nome
                        WHERE iddisciplina = :iddisciplina";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':iddisciplina', $iddisciplina);
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