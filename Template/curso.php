<?php
    //ini_set("display_errors", 1);
    require_once('../Model/curso.php');
    $objCurso = new Curso();   
    //$result = $objCurso->getAllCursos();
    //var_dump($result,"<br>");

    //foreach ($result as $array) {
      //var_dump($array,"<br>");
    //}
    //exit();
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
    <title>Aprenda Mais - Cursos</title>
    <link rel="icon" type="image/x-icon" href="./img/Aprenda-Mais-logo.ico">
</head>
<body>
<?php 
  include('navegacao.php');
?>
<div class="container">
  <h2>Lista dos Cursos</h2>
  <?php
if (isset($_GET['message'])) {
    $responseMessage = $_GET['message'];
    echo '<div class="alert alert-danger">' . $responseMessage . '</div>';
}
?>
    
  <p>
    <button type="button" class="btn btn-success">
      <a data-toggle="modal" 
      data-target="#myModalCadastrar">Cadastrar</a></button>
  </p>  
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Disciplinas</th>
        <th>Editar</th>
        <th>Deletar</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $query = "SELECT * FROM curso";
        $stmt = $objCurso->runQuery($query);
        $stmt->execute();
        while($objCurso = $stmt->fetch(PDO::FETCH_ASSOC)){        
      ?>
            <tr>
              <td><?php echo($objCurso['nome']); ?></td>
              <td>
                  <button type="button" class="btn btn-secondary"
                  data-toggle="modal" 
                  data-target="#myModalDisciplina"
                  data-id="<?php echo($objCurso['idcurso']);?>"
                  data-nome="<?php echo($objCurso['nome']);?>"
                  >Adicionar</button>
              </td>
              <td>
                  <button type="button" class="btn btn-warning"
                  data-toggle="modal" 
                  data-target="#myModalEditar"
                  data-id="<?php echo($objCurso['idcurso']);?>"
                  data-nome="<?php echo($objCurso['nome']);?>"
                  >Editar</button>
              </td>
              <td>
                  <button type="button" class="btn btn-danger"
                  data-toggle="modal" data-target="#myModalDeletar" 
                  data-id="<?php echo($objCurso['idcurso']);?>"
                  data-nome="<?php echo($objCurso['nome']);?>"
                  >Deletar</button>
              </td>
            </tr>
      <?php
        }
      ?>
    </tbody>
  </table>
</div>

<!-- The Cadastrar -->
<div class="modal" id="myModalCadastrar">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" style="background-color: green; color: white;">
          <h4 class="modal-title">Novo Curso</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <form action="../controller/cursoController.php" method="post">
             <input type="hidden" name="insert" >
        <div class="form-group">
            <label for="email">Nome:</label>
            <input type="text" class="form-control" placeholder="Curso ..." id="Nome" name="txtNome">
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
                </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        </div>
        
      </div>
    </div>
  </div>


<!-- The Delete -->
<div class="modal" id="myModalDeletar">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" style="background-color: green; color: white;">
          <h4 class="modal-title">Apagar Curso</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <form action="../controller/cursoController.php" method="post">
             <input type="hidden" name="delete" id="recipient-id">
        <div class="form-group">
            <label for="text">Nome do Curso:</label>
            <input type="text" class="form-control" 
            placeholder="informe nome" 
            id="recipient-nome"
            name="nome" readOnly>
            <p class="ml-2 pt-2">Essa ação apagará todas informações associadas ao mesmo</p>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Apagar</button>
          </form>
        </div>
        
      </div>
    </div>
  </div>
</div>

<!-- The Up -->
<div class="modal" id="myModalEditar">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" style="background-color: green; color: white;">
          <h4 class="modal-title">Editar Curso</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <form action="../controller/cursoController.php" method="post">
             <input type="hidden" name="updateId" id="recipient-id">
        <div class="form-group">
            <label for="text">Nome do Curso:</label>
            <input type="text" class="form-control mb-3" placeholder="Novo nome" name="txtNome" id="recipient-nome">
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

<!-----Update---->
<div class="modal" id="myModalDisciplina">
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
             <input type="hidden" name="insertDisciplina" id="recipient-id">
             <div class="form-group">
            <label for="text">Nome do Curso:</label>
            <input type="text" class="form-control" placeholder="Novo nome" name="txtNome" id="recipient-nome" readOnly>
            </div>
            <div class="form-group">
            <label for="text">Nome da Disciplina:</label>
            <input type="text" class="form-control" placeholder="Disciplina ..." name="txtDiscplinaNome" id="recipient-disciplina">
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  

  <script>
    $('#myModalDisciplina').on('show.bs.modal',function (event){
      var button = $(event.relatedTarget);
      var recipientId = button.data('id');
      var recipientNome = button.data('nome');
    
      var modal = $(this);
      modal.find('#recipient-id').val(recipientId);
      modal.find('#recipient-nome').val(recipientNome)
    });
  </script>
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
