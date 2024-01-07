<?php
    require_once('conexao.php');

    class Professor{
        private $conn;

        public function __construct(){
            $dataBase = new dataBase();
            $this->conn = $dataBase->dbConnection();
        }

        public function runQuery($sql){
            $stmt = $this->conn->prepare($sql);
            return $stmt;
        }

        public function insert($nome, $email)
{
    try {

        $checkQuery = "SELECT * FROM professor WHERE email = :email";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {

            return false;
        }

        $sql = "INSERT INTO professor(nome, email) VALUES(:nome, :email)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

        public function deletar($idprofessor){
            try{
                $sql = "DELETE FROM professor where idprofessor = :idprofessor";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':idprofessor', $idprofessor);
                $stmt->execute();
                return $stmt;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function editar($nome, $email, $idprofessor){
            try{
                $sql = "UPDATE professor SET
                        nome = :nome,
                        email = :email
                        WHERE idprofessor = :idprofessor";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':idprofessor', $idprofessor);
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