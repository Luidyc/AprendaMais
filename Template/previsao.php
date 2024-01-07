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
if ($selectedTurma) {
  $queryAlunos = "SELECT A.*, D.falta, D.previsoes FROM aluno A
    INNER JOIN desempenho_aluno_turma D ON A.matricula = D.matricula
    WHERE D.idturma = :idturma
    ORDER BY $selectedOrder";
  $stmtAlunos = $objAluno->runQuery($queryAlunos);
  $stmtAlunos->bindParam(':idturma', $selectedTurma, PDO::PARAM_INT);
  $stmtAlunos->execute();
  $alunos = $stmtAlunos->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aprenda Mais - Previsões</title>
  <link rel="icon" type="image/x-icon" href="./img/Aprenda-Mais-logo.ico">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
  <?php include('navegacao.php'); ?>
  <div class="container">
    <h2>Análise de Risco</h2>
    <p>Somente disponivéis para turmas em andamento</p>
    <form method="post" class="form-inline">
      <div class="form-group mr-2">
        <label for="turma" class="mr-2">Selecione a turma:</label>
        <select name="turma" id="turma" class="form-control">
          <?php
          $queryTurmas = "SELECT idturma,nome,tipodeturma FROM turma
                    where tipodeturma = 'A'";
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
      <!-- <button type="button" class="btn btn-primary ml-2" onclick="calcularPrevisaoTodos()">Calcular Previsão</button> -->
    </form>
    <div class="alert alert-info" role="alert">
      <strong>Total de Alunos:</strong> <?php echo count($alunos); ?>
    </div>
    <button type="button" class="btn btn-primary" id="calcularPrevisaoBtn">Calcular e Inserir Previsões</button>
    <!-- Tabela de alunos -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Matrícula</th>
          <th>Nome</th>
          <th>Telefone</th>
          <th>Email</th>
          <th>Faltas</th>
          <th>Nota Prevista</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($alunos as $aluno) {
          echo "<tr id='aluno_{$aluno['matricula']}'>";
          echo "<td>{$aluno['matricula']}</td>";
          echo "<td>{$aluno['nome']}</td>";
          echo "<td>{$aluno['telefone']}</td>";
          echo "<td>{$aluno['email']}</td>";
          echo "<td>{$aluno['falta']}</td>";
          echo "<td>{$aluno['previsoes']}</td>";
          echo "</td>";
          echo "</tr>";
        }

        ?>
      </tbody>
    </table>
  </div>

  <script>
    function calcularPrevisao(matricula, idTurma, falta) {

      $('#myModal').modal('show');


      var info = "Matrícula: " + matricula + "<br>Turma: " + idTurma;
      $('#matricula-turma-info').html(info);


      $('#falta').val(falta);


      $.ajax({
        url: '../Model/previsao.php',
        type: 'POST',
        data: {
          matricula: matricula,
          idTurma: idTurma,
          falta: falta
        },
        success: function(response) {

          $('#nota').val(response);
        },
        error: function(error) {
          console.log(error);
        }
      });
    }
    $(document).ready(function() {

      $("#calcularPrevisaoBtn").click(function() {

        var selectedTurma = $("#turma").val();

        if (selectedTurma) {

          $.ajax({
            url: '../Controller/prevercontroller.php',
            type: 'POST',
            data: {
              idturma: selectedTurma
            },
            success: function(response) {

              alert('Previsões calculadas e inseridas no banco de dados com sucesso!');

              location.reload();
            },
            error: function(error) {
              console.log(error);

              alert('Erro ao calcular e inserir previsões.');
            }
          });
        } else {
          alert('Selecione uma turma antes de calcular a previsão.');
        }
      });
    });
  </script>