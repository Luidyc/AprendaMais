<?php
require_once('../Model/aluno.php');
$objAluno = new Aluno();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csvFile"])) {
    $selectedTurma = isset($_POST['selectedTurma']) ? $_POST['selectedTurma'] : null;   
    // Diretório onde os arquivos CSV serão salvos temporariamente, apaga isso aq n
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["csvFile"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($fileType != "csv") {
        echo "Apenas arquivos CSV são permitidos.";
        $uploadOk = 0;
    }

    if (file_exists($targetFile)) {
        echo "Desculpe, o arquivo já existe.";
        $uploadOk = 0;
    }

    if ($_FILES["csvFile"]["size"] > 500000) {
        echo "Desculpe, o arquivo é muito grande.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "O arquivo não foi enviado.";
    } else {
        if (move_uploaded_file($_FILES["csvFile"]["tmp_name"], $targetFile)) {
            echo "O arquivo " . basename($_FILES["csvFile"]["name"]) . " foi enviado com sucesso.";

            $csvData = array_map('str_getcsv', file($targetFile));
            array_shift($csvData);

            foreach ($csvData as $row) {
                $matricula = $row[0];
                $nome = $row[1];
                $telefone = $row[2];
                $email = $row[3];

                // Verifica se a matrícula já existe na tabela aluno
                $queryCheckMatricula = "SELECT COUNT(*) as count FROM aluno WHERE matricula = :matricula";
                $stmtCheckMatricula = $objAluno->runQuery($queryCheckMatricula);
                $stmtCheckMatricula->bindParam(':matricula', $matricula, PDO::PARAM_STR);
                $stmtCheckMatricula->execute();
                $result = $stmtCheckMatricula->fetch(PDO::FETCH_ASSOC);

                if ($result['count'] > 0) {
                    // A matrícula já existe, apenas atualiza a tabela desempenho_aluno_turma se a turma for selecionada
                    if ($selectedTurma !== null && !empty($selectedTurma)) {
                        $queryDesempenho = "INSERT INTO desempenho_aluno_turma (matricula, idturma) VALUES (:matricula, :idturma)";
                        $stmtDesempenho = $objAluno->runQuery($queryDesempenho);
                        $stmtDesempenho->bindParam(':matricula', $matricula, PDO::PARAM_STR);
                        $stmtDesempenho->bindParam(':idturma', $selectedTurma, PDO::PARAM_INT);
                        $stmtDesempenho->execute();
                    }
                } else {
                    // A matrícula não existe, insere na tabela aluno e desempenho_aluno_turma se a turma for selecionada
                    $queryInsert = "INSERT INTO aluno (matricula, nome, telefone, email) VALUES (:matricula, :nome, :telefone, :email)";
                    $stmtInsert = $objAluno->runQuery($queryInsert);
                    $stmtInsert->bindParam(':matricula', $matricula, PDO::PARAM_STR);
                    $stmtInsert->bindParam(':nome', $nome, PDO::PARAM_STR);
                    $stmtInsert->bindParam(':telefone', $telefone, PDO::PARAM_STR);
                    $stmtInsert->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmtInsert->execute();

                    if ($selectedTurma !== null && !empty($selectedTurma)) {
                        $queryDesempenho = "INSERT INTO desempenho_aluno_turma (matricula, idturma) VALUES (:matricula, :idturma)";
                        $stmtDesempenho = $objAluno->runQuery($queryDesempenho);
                        $stmtDesempenho->bindParam(':matricula', $matricula, PDO::PARAM_STR);
                        $stmtDesempenho->bindParam(':idturma', $selectedTurma, PDO::PARAM_INT);
                        $stmtDesempenho->execute();
                    }
                }
            }
            unlink($targetFile);
            // Redirecionar de volta para a página original
            header("Location: ../Template/aluno.php?success=true");
            exit();
        } else {
            echo "Desculpe, ocorreu um erro ao enviar o arquivo.";
        }
    }
}

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    $queryDelete = "DELETE FROM desempenho_aluno_turma WHERE matricula = :matricula";
    $stmtDelete = $objAluno->runQuery($queryDelete);
    $stmtDelete->bindParam(':matricula', $matricula, PDO::PARAM_STR);
    $stmtDelete->execute();

    header("Location: ../Template/aluno.php");
    exit();
}
?>