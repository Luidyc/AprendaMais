<?php
/**
 * @todo implementar a PSR4
 * @link https://www.php-fig.org/psr/psr-4/
 */
    require_once('conexao.php');

    class Turma{
        private $conn;

        public function __construct(){
            $dataBase = new dataBase();
            $this->conn = $dataBase->dbConnection();
        }

        /**
         * @todo Verificar o objetivo deste método. Está em uso?
         */
        public function runQuery($sql){
            $stmt = $this->conn->prepare($sql);
            return $stmt;
        }
        
        public function getByCurso($idCurso) {
            try {
                $sql = "SELECT T.idturma, T.NOME AS TURMA, D.NOME as DISCIPLINA, D.idcurso,
                P.NOME AS PROFESSOR
                FROM turma as T
                INNER JOIN disciplina AS D
                ON D.iddisciplina  = T.iddisciplina 
                INNER JOIN professor AS P
                ON P.idprofessor = T.idprofessor
                WHERE :idcurso = D.idcurso";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':idcurso', $idCurso);
                $stmt->execute();
                return $stmt;
                }catch(PDOException $e){
                    echo $e->getMessage();
                }   
        }

        public function inserirDesempenhoAluno($matricula, $idTurma, $nota, $falta) {
            try {
                // Verificar se a matricula existe na tabela aluno
                $verificarMatricula = "SELECT * FROM aluno WHERE matricula = :matricula";
                $stmtVerificarMatricula = $this->conn->prepare($verificarMatricula);
                $stmtVerificarMatricula->bindParam(':matricula', $matricula);
                $stmtVerificarMatricula->execute();
                $alunoExistente = $stmtVerificarMatricula->fetch();
        
                if ($alunoExistente) {
                    // A matricula existe na tabela aluno, pode prosseguir com a inserção na tabela desempenho_aluno_turma
                    $sql = "INSERT INTO desempenho_aluno_turma (matricula, idturma, nota, falta) VALUES (:matricula, :idturma, :nota, :falta)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':matricula', $matricula);
                    $stmt->bindParam(':idturma', $idTurma);
                    $stmt->bindParam(':nota', $nota);
                    $stmt->bindParam(':falta', $falta);
                    $stmt->execute();
                    return true; // Retorna true se a inserção for bem-sucedida
                } else {
                    echo "Erro: A matricula não existe na tabela aluno.";
                    return false; // Retorna false se a matricula não existe na tabela aluno
                }
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
                return false; // Retorna false se ocorrer um erro durante a inserção
            }
        }


        public function insert($nome, $tipodeturma, $idprofessor, $iddisciplina)
        {
            try {
                if (empty($nome)) {
                    $errorMessage = "Erro: Turma sem nome.";
                    header("Location: ../Template/turma.php?message=" . urlencode($errorMessage));
                    exit();
                }
        
                $checkIfExistsQuery = "SELECT COUNT(*) as count FROM turma WHERE nome = :nome AND idprofessor = :idprofessor AND iddisciplina = :iddisciplina";
                $checkIfExistsStmt = $this->conn->prepare($checkIfExistsQuery);
                $checkIfExistsStmt->bindParam(':nome', $nome);
                $checkIfExistsStmt->bindParam(':idprofessor', $idprofessor);
                $checkIfExistsStmt->bindParam(':iddisciplina', $iddisciplina);
                $checkIfExistsStmt->execute();
                $classExists = $checkIfExistsStmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
        
                if ($classExists) {
                    $errorMessage = "Erro: Turma já existente.";
                    header("Location: ../Template/turma.php?message=" . urlencode($errorMessage));
                    exit();
                }
        
                $sql = "INSERT INTO turma(iddisciplina, nome, idprofessor, tipodeturma, data_registro)
                        VALUES(:iddisciplina, :nome, :idprofessor, :tipodeturma, now())";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':iddisciplina', $iddisciplina);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':idprofessor', $idprofessor);
                $stmt->bindParam(':tipodeturma', $tipodeturma);
                $stmt->execute();
                return $stmt;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        
        public function deletar($idturma){
            try{
                $sql = "DELETE FROM turma
                WHERE idturma = :idturma";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':idturma', $idturma);
                $stmt->execute();
                return $stmt;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function editar($idturma,$nome,$tipodeturma,$professor,$disciplina){
            try{
                $sql = "UPDATE turma SET
                        nome = :nome,
                        tipodeturma = :tipodeturma,
                        idprofessor = :idprofessor,
                        iddisciplina = :iddisciplina
                        WHERE idturma = :idturma";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':tipodeturma', $tipodeturma);
                $stmt->bindParam(':idprofessor', $professor);
                $stmt->bindParam(':iddisciplina', $disciplina);
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