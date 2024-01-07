<?php
require_once('../Model/turma.php');
$objTurma = new Turma();
require_once('../Model/curso.php');
$objCursos = new Curso();
require_once('../Model/disciplina.php');
$objDisciplinas = new Disciplina();
require_once('../Model/professor.php');
$objProfessores = new Professor();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <title>Aprenda Mais - Turmas</title>
  <link rel="icon" type="image/x-icon" href="./img/Aprenda-Mais-logo.ico">
</head>

<body>
  <?php
  include('navegacao.php');
  ?>
  <div class="container">
    <h2>Cadastro de Turmas</h2>
              <?php
      if (isset($_GET['message'])) {
          $responseMessage = $_GET['message'];
          echo '<div class="alert alert-danger">' . $responseMessage . '</div>';
      }
      ?>
    <p class="ml-2">
      <?php
      $query = "SELECT * FROM disciplina";
      $stmt = $objDisciplinas->runQuery($query);
      $stmt->execute();
      $objDisciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <form action="" method="post">
    <label for="disciplina">Selecione uma disciplina:</label>
    <select name="disciplina" id="disciplina" onchange="this.form.submit()">
        <option value="">Selecione</option>
        <?php foreach ($objDisciplinas as $objDisciplina) { ?>
            <option value="<?php echo $objDisciplina['iddisciplina']; ?>" <?php echo isset($_POST['disciplina']) && $_POST['disciplina'] == $objDisciplina['iddisciplina'] ? 'selected' : ''; ?>><?php echo $objDisciplina['nome']; ?></option>
        <?php } ?>
    </select>
</form>

    </p>
    <p>
      <button type="button" class="btn btn-success">
        <a data-toggle="modal" data-target="#myModalCadastrar">Cadastrar</a></button>
    </p>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Turma</th>
          <th>Disciplina</th>
          <th>Professor</th>
          <th>Desempenho</th>
          <th>Editar</th>
          <th>Deletar</th>
          <th>Situação</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_POST['disciplina']) && !empty($_POST['disciplina'])) {
          $selectedDisciplinaId = $_POST['disciplina'];
          $query = "SELECT T.idturma, T.nome AS TURMA, D.nome AS DISCIPLINA, P.nome AS PROFESSOR, COUNT(DAT.matricula) AS QTD_ALUNOS
          FROM turma AS T
          INNER JOIN disciplina AS D ON D.iddisciplina = T.iddisciplina
          INNER JOIN professor AS P ON P.idprofessor = T.idprofessor
          LEFT JOIN desempenho_aluno_turma AS DAT ON DAT.idturma = T.idturma
          WHERE T.iddisciplina = :iddisciplina
          GROUP BY T.idturma, T.nome, D.nome, P.nome";

          $stmt = $objTurma->runQuery($query);
          $stmt->bindParam(':iddisciplina', $selectedDisciplinaId);
          $stmt->execute();

          while ($objTurma = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <tr>
              <td><?php echo ($objTurma['TURMA']); ?></td>
              <td><?php echo ($objTurma['DISCIPLINA']); ?></td>
              <td><?php echo ($objTurma['PROFESSOR']); ?></td>
              <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalImportarDesempenho" data-id="<?php echo ($objTurma['idturma']); ?>" data-turma="<?php echo ($objTurma['TURMA']); ?>">Importar</button>
              </td>
              <td>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModalEditar" data-id="<?php echo ($objTurma['idturma']); ?>" data-turma="<?php echo ($objTurma['TURMA']); ?>" data-disciplina="<?php echo ($objTurma['DISCIPLINA']); ?>" data-professor="<?php echo ($objTurma['PROFESSOR']); ?>">Editar</button>
              </td>
              <td>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalDeletar" data-id="<?php echo ($objTurma['idturma']); ?>" data-turma="<?php echo ($objTurma['TURMA']); ?>">Deletar</button>
              </td>
              <td>
                <?php
                if ($objTurma['QTD_ALUNOS'] > 0) {
                  echo "Upload realizado" . " 🟢";
                } else {
                  echo "Upload não realizado" . " 🔴";
                }
                ?>
              </td>
            </tr>
        <?php
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <!-- Modal Cadatrar -->
  <div class="modal" id="myModalCadastrar">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header" style="background-color: green; color: white;">
          <h4 class="modal-title">Nova Turma</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form action="../controller/turmaController.php" method="post">
            <input type="hidden" name="insertTurma">
            <div class="form-group">
              <label for="pwd">Nome da Turma:</label>
              <input type="text" class="form-control" placeholder="Nova turma ..." name="txtNome">
            </div>
            <div class="form-group">
              <label for="pwd">Tipo de turma:</label>
              <select name="txtTipoDeTurma" id="tipoDeTurma">
                <option value="F">Finalizada</option>
                <option value="A">Em Andamento</option>
              </select>
            </div>
            <div class="form-group">
              <label for="pwd">Selecione um professor: </label>
              <select name="professor">
                <?php
                $query = "select * from professor";
                $stmt = $objProfessores->runQuery($query);
                $stmt->execute();
                $objProfessores = $stmt->fetchAll(PDO::FETCH_ASSOC)
                ?>
                <?php foreach ($objProfessores as $objProfessor) { ?>
                  <option name="txtProfessor" value="<?php echo ($objProfessor['idprofessor']); ?>"><?php echo ($objProfessor['nome']); ?></option>
                <?php
                }
                ?>
              </select>
              </div>
            <div class="form-group">
              <label for="pwd">Selecione uma disciplina: </label>
              <select name="disciplina">
                <?php foreach ($objDisciplinas as $objDisciplina) { ?>
                  
                  <option name="txtDisciplina" value="<?php echo ($objDisciplina['iddisciplina']); ?>"><?php echo ($objDisciplina['nome']); ?></option>
                <?php
                }
                ?>
              </select>
              <button type="submit" class="btn btn-primary">Cadastrar</button>
          </form>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <div class="modal" id="myModalDeletar">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header" style="background-color: green; color: white;">
          <h4 class="modal-title">Deletar Turma</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form action="../controller/turmaController.php" method="post">
            <input type="hidden" name="delete" id="recipient-id">
            <div class="form-group">
              <label for="text">Nome da Turma:</label>
              <input type="text" class="form-control" id="recipient-turma" name="nome" readOnly>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger">Deletar</button>
          </form>
        </div>

      </div>
    </div>
  </div>
  </div>


  <div class="modal" id="myModalEditar">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header" style="background-color: green; color: white;">
          <h4 class="modal-title">Editar Turma</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form action="../controller/turmaController.php" method="post">
            <input type="hidden" name="updateId" id="recipient-id">
            <div class="form-group">
              <label for="text"> Altere o nome da Turma:</label>
              <input type="text" class="form-control" id="recipient-turma" name="txtNome">
            </div>
            <div class="form-group">
              <label for="pwd">Altere o tipo de turma:</label>
              <select name="txtTipoDeTurma" id="tipoDeTurma">
                <option value="F">Finalizada</option>
                <option value="A">Em Andamento</option>
              </select>
            </div>
            <div class="form-group">
              <label for="pwd">Altere o professor: </label>
              <select name="professor">
                <?php foreach ($objProfessores as $objProfessor) { ?>
                  <option name="txtProfessor" value="<?php echo ($objProfessor['idprofessor']); ?>"><?php echo ($objProfessor['nome']); ?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="pwd">Altere a disciplina: </label>
              <select name="disciplina">
                <?php foreach ($objDisciplinas as $objDisciplina) { ?>
                  <option name="txtDisciplina" value="<?php echo ($objDisciplina['iddisciplina']); ?>"><?php echo ($objDisciplina['nome']); ?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Salvar</button>
          </form>
        </div>

      </div>
    </div>
  </div>
  </div>


  <div class="modal" id="myModalImportarDesempenho">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header" style="background-color: green; color: white;">
          <h4 class="modal-title">Importe de desempenho dos Alunos</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form action="../controller/desempenhoController.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="turma_id" id="recipient-id">
            <div class="form-group">
              <label for="text">Nome da Turma:</label>
              <input type="text" class="form-control" id="recipient-turma" name="nome" readOnly>
            </div>
            <div class="form-group">
              <label for="arquivo_desempenho">Selecione o arquivo de desempenho (CSV):</label>
              <input type="file" name="arquivo_desempenho" id="arquivo_desempenho" accept=".csv">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Importar</button>
          </form>
        </div>

      </div>
    </div>
  </div>



<script>
  // Your JavaScript code remains unchanged
  $('#myModalDeletar').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var recipientId = button.data('id');
    var recipientTurma = button.data('turma');

    var modal = $(this);
    modal.find('#recipient-id').val(recipientId);
    modal.find('#recipient-turma').val(recipientTurma);
  });

  $('#myModalEditar').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var recipientId = button.data('id');
    var recipientTurma = button.data('turma');

    var modal = $(this);
    modal.find('#recipient-id').val(recipientId);
    modal.find('#recipient-turma').val(recipientTurma);
  });

  $('#myModalImportarDesempenho').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var recipientId = button.data('id');
    var recipientTurma = button.data('turma');

    var modal = $(this);
    modal.find('#recipient-id').val(recipientId);
    modal.find('#recipient-turma').val(recipientTurma);
  });
</script>
</body>

</html>