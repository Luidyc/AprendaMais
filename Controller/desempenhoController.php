<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $turma_id = $_POST["turma_id"];


    if (isset($_FILES["arquivo_desempenho"]) && $_FILES["arquivo_desempenho"]["error"] == 0) {

        $caminho_arquivo = "uploads/" . $_FILES["arquivo_desempenho"]["name"];

        move_uploaded_file($_FILES["arquivo_desempenho"]["tmp_name"], $caminho_arquivo);


        $dados_csv = array_map('str_getcsv', file($caminho_arquivo));


        $conexao = new mysqli("localhost", "root", "", "aprendendomaisphp");


        if ($conexao->connect_error) {
            die("Falha na conexão: " . $conexao->connect_error);
        }


        foreach ($dados_csv as $linha) {


            $matricula_aluno = $linha[0];
        

            $nota = $linha[1];
            $faltas = $linha[2];
        

            $consulta_matricula = "SELECT * FROM aluno WHERE matricula = '$matricula_aluno'";
            $resultado_matricula = $conexao->query($consulta_matricula);
        
            if ($resultado_matricula->num_rows > 0) {
        
                $consulta_existencia = "SELECT * FROM desempenho_aluno_turma WHERE matricula = '$matricula_aluno' AND idturma = $turma_id";
        
                $resultado_existencia = $conexao->query($consulta_existencia);
        
                if ($resultado_existencia->num_rows > 0) {

                    $atualizacao_dados = "UPDATE desempenho_aluno_turma SET nota = $nota, falta = $faltas WHERE matricula = '$matricula_aluno' AND idturma = $turma_id";
                    $conexao->query($atualizacao_dados);
                } else {

                    $insercao_dados = "INSERT INTO desempenho_aluno_turma (matricula, idturma, nota, falta) VALUES ('$matricula_aluno', $turma_id, $nota, $faltas)";
                    $conexao->query($insercao_dados);
                }
            } else {
                echo "Erro: A matrícula $matricula_aluno não existe na tabela aluno.";
            }
        }

        // Fecha a conexão
        $conexao->close();

        header("Location: ../Template/turma.php");
    } else {
        echo "Erro: Nenhum arquivo enviado.";
    }
} else {
    echo "Erro: Formulário não submetido.";
}
?>
