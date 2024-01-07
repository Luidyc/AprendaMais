<?php
require_once('../Model/turma.php');
$objTurma = new Turma();
require_once('../Model/curso.php');
$objCursos = new Curso();
require_once('../Model/disciplina.php');
$objDisciplinas = new Disciplina();
require_once('../Model/professor.php');
$objProfessores = new Professor();
require_once('../Model/aluno.php');
$objAluno = new Aluno();

$selectedTurma = isset($_POST['turma']) ? $_POST['turma'] : null;
$selectedOrder = isset($_POST['order']) ? $_POST['order'] : 'matricula';

$alunos = [];
if ($selectedTurma && $selectedTurma != 'todos') {
    $queryAlunos = "SELECT A.* FROM aluno A
                    INNER JOIN desempenho_aluno_turma D ON A.matricula = D.matricula
                    WHERE D.idturma = :idturma
                    ORDER BY $selectedOrder";
    $stmtAlunos = $objAluno->runQuery($queryAlunos);
    $stmtAlunos->bindParam(':idturma', $selectedTurma, PDO::PARAM_INT);
} else {
    // Buscar todos os alunos da instituição
    $queryAlunos = "SELECT * FROM aluno";
    $stmtAlunos = $objAluno->runQuery($queryAlunos);
}

$stmtAlunos->execute();
$alunos = $stmtAlunos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprenda Mais - Alunos</title>
    <link rel="icon" type="image/x-icon" href="./img/Aprenda-Mais-logo.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <?php include('navegacao.php'); ?>
    <div class="container">
        <h2>Lista de Alunos</h2>

        <form method="post" class="form-inline">
            <div class="form-group mr-2">
                <label for="turma" class="mr-2">Selecione a turma:</label>
                <select name="turma" id="turma" class="form-control">
                    <option value="todos" <?php echo ($selectedTurma == 'todos') ? 'selected' : ''; ?>>Todos os Alunos da Instituição</option>
                    <?php
                    $queryTurmas = "SELECT * FROM turma";
                    $stmtTurmas = $objTurma->runQuery($queryTurmas);
                    $stmtTurmas->execute();
                    $turmas = $stmtTurmas->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($turmas as $turma) {
                        $selected = ($selectedTurma == $turma['idturma']) ? 'selected' : '';
                        echo "<option value='{$turma['idturma']}' $selected>{$turma['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mr-2">
                <label for="order" class="mr-2">Ordem:</label>
                <select name="order" id="order" class="form-control">
                    <option value="matricula" <?php echo ($selectedOrder == 'matricula') ? 'selected' : ''; ?>>Por Matrícula</option>
                    <option value="nome" <?php echo ($selectedOrder == 'nome') ? 'selected' : ''; ?>>Por Nome</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Filtrar</button>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importModal">
                Importar CSV
            </button>
        </form>

        <div class="alert alert-info" role="alert">
            <strong>Total de Alunos:</strong> <?php echo count($alunos); ?>
        </div>

        <!-- Tabela de alunos -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <?php
                    if ($selectedTurma != 0 && $selectedTurma != 'todos') {
                    echo"<th>Ações</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($alunos as $aluno) {
                    echo "<tr>";
                    echo "<td>{$aluno['matricula']}</td>";
                    echo "<td>{$aluno['nome']}</td>";
                    echo "<td>{$aluno['telefone']}</td>";
                    echo "<td>{$aluno['email']}</td>";
                    if ($selectedTurma != 0 && $selectedTurma != 'todos') {
                    echo "<td><button class='btn btn-danger' onclick='excluirAluno(\"{$aluno['matricula']}\")'>Excluir</button></td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de importação CSV -->
    <div class="modal" id="importModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="background-color: green; color: white;">
                    <h4 class="modal-title">Importar CSV</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="../Controller/alunoController.php">
                        <div class="form-group">
                            <label for="turmaCSV">Selecione a turma:</label>
                            <select name="selectedTurma" class="form-control" id="turmaCSV">
                                <option value="">Importar Alunos da Instituição</option>
                                <?php
                                foreach ($turmas as $turma) {
                                    $selected = ($selectedTurma == $turma['idturma']) ? 'selected' : '';
                                    echo "<option value='{$turma['idturma']}' $selected>{$turma['nome']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="csvFile">Escolha um arquivo CSV com os Alunos:</label>
                            <input type="file" class="form-control-file" id="csvFile" name="csvFile" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Importar</button>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function excluirAluno(matricula) {
            var confirmacao = confirm("Tem certeza que deseja excluir este aluno?");

            if (confirmacao) {
                window.location.href = "../Controller/alunoController.php?matricula=" + matricula;
            }
        }
    </script>
</body>

</html>
