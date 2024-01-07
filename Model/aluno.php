<?php

require_once('conexao.php');

class Aluno
{
    private $conn;

    public function __construct(){
        $dataBase = new dataBase();
        $this->conn = $dataBase->dbConnection();
    }

    public function runQuery($sql)
    {
        return $this->conn->prepare($sql);
    }

    public function cadastrarAluno($matricula, $nome, $telefone, $email)
    {
        try {
            $sql = "INSERT INTO aluno (matricula, nome, telefone, email) VALUES (:matricula, :nome, :telefone, :email)";
            $stmt = $this->runQuery($sql);
            $stmt->bindParam(":matricula", $matricula, PDO::PARAM_STR);
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":telefone", $telefone, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function obterTodosAlunos()
    {
        try {
            $sql = "SELECT * FROM aluno";
            $stmt = $this->runQuery($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function pesquisarAlunos($termo)
    {
        try {
            $sql = "SELECT * FROM aluno WHERE nome LIKE :termo OR matricula LIKE :termo";
            $stmt = $this->runQuery($sql);
            $termo = "%$termo%";
            $stmt->bindParam(":termo", $termo, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function editarAluno($matricula, $nome, $telefone, $email)
    {
        try {
            $sql = "UPDATE aluno SET nome = :nome, telefone = :telefone, email = :email WHERE matricula = :matricula";
            $stmt = $this->runQuery($sql);
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":telefone", $telefone, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":matricula", $matricula, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function excluirAluno($matricula)
    {
        try {
            $sql = "DELETE FROM aluno WHERE matricula = :matricula";
            $stmt = $this->runQuery($sql);
            $stmt->bindParam(":matricula", $matricula, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // Adicione outras funções conforme necessário, como obterAlunoPorMatricula, etc.
}

?>
