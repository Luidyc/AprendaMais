<?php
    require_once('../Model/curso.php');
    $objCursos = new Curso();
    require_once('../Model/disciplina.php');
    $objDisciplinas = new Disciplina();
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
    <title>Aprenda Mais - Disciplinas</title>
    <link rel="icon" type="image/x-icon" href="./img/Aprenda-Mais-logo.ico">
</head>
<body>
<?php 
  include('navegacao.php');
?>
<div class="container">
  <h2 class="">Lista de Disciplinas</h2>
  <p class="ml-2">
    <?php 
        $query = "SELECT * FROM curso";
        $stmt = $objCursos->runQuery($query);
        $stmt->execute();
        $objCursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <form action="" method="post">
      <label for="curso">Selecione um curso:</label>
      <select name="curso" id="curso" onchange="this.form.submit()">
        <option value="">Selecione</option>
        <?php foreach ($objCursos as $objCurso) { ?>
          <option value="<?php echo $objCurso['idcurso']; ?>" <?php echo isset($_POST['curso']) && $_POST['curso'] == $objCurso['idcurso'] ? 'selected' : ''; ?>><?php echo $objCurso['nome']; ?></option>
        <?php } ?>
      </select>
    </form>
  </p>

  <?php
    if(isset($_POST['curso']) && !empty($_POST['curso'])) {
      $selectedCursoId = $_POST['curso'];
      $query = "SELECT * FROM disciplina WHERE idcurso = :idcurso";
      $stmt = $objDisciplinas->runQuery($query);
      $stmt->bindParam(':idcurso', $selectedCursoId);
      $stmt->execute();
      $objDisciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Editar</th>
        <th>Deletar</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($objDisciplinas as $objDisciplina) {?> 
        <tr>
          <td><?php echo($objDisciplina['nome']); ?></td>
          <td>
            <button type="button" class="btn btn-warning"
              data-toggle="modal" 
              data-target="#myModalEditar"
              data-id="<?php echo($objDisciplina['iddisciplina']);?>"
              data-nome="<?php echo($objDisciplina['nome']);?>"
            >Editar</button>
          </td>
          <td>
            <button type="button" class="btn btn-danger"
              data-toggle="modal" data-target="#myModalDeletar" 
              data-id="<?php echo($objDisciplina['iddisciplina']);?>"
              data-nome="<?php echo($objDisciplina['nome']);?>"
            >Deletar</button>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php } ?>
</div>



<div class="modal" id="myModalDeletar">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" style="background-color: green; color: white;">
          <h4 class="modal-title">Apagar Disciplina</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <form action="../controller/disciplinaController.php" method="post">
             <input type="hidden" name="delete" id="recipient-id">
        <div class="form-group">
            <label for="text">Nome da Disciplina:</label>
            <input type="text" class="form-control" 
            placeholder="informe nome" 
            id="recipient-nome"
            name="nome" readOnly>
            <p class="ml-2 pt-2">Essa ação apagará todas informações associadas ao mesmo</p>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Apagar</button>
        </div>
        
      </div>
    </div>
  </div>
</div>
<!-----Update---->
<div class="modal" id="myModalEditar">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" style="background-color: green; color: white;">
          <h4 class="modal-title">Editar Disciplina</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <form action="../controller/disciplinaController.php" method="post">
             <input type="hidden" name="updateId" id="recipient-id">
             <div class="form-group">
            <label for="text">Nome da Disciplina:</label>
            <input type="text" class="form-control" placeholder="Novo nome" name="txtNome" id="recipient-nome">
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>


  <script>
    $('#myModalDeletar').on('show.bs.modal',function (event){
      var button = $(event.relatedTarget);
      var recipientId = button.data('id');
      var recipientNome = button.data('nome');
    
      var modal = $(this);
      modal.find('#recipient-id').val(recipientId);
      modal.find('#recipient-nome').val(recipientNome)
    });
  </script>
  <script>
    $('#myModalEditar').on('show.bs.modal',function (event){
      var button = $(event.relatedTarget);
      var recipientId = button.data('id');
      var recipientNome = button.data('nome');
    
      var modal = $(this);
      modal.find('#recipient-id').val(recipientId);
      modal.find('#recipient-nome').val(recipientNome);
    });
    </script>
</body>
</html>
