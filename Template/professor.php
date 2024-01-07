<?php
    require_once('../Model/professor.php');
    $objProfessor = new Professor();
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
    <title>Aprenda Mais - Professores</title>
    <link rel="icon" type="image/x-icon" href="./img/Aprenda-Mais-logo.ico">
</head>
<body>
<?php 
  include('navegacao.php');
?>
<div class="container">
  <h2>Lista de Professores</h2>
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
        <th>Email</th>
        <th>Editar</th>
        <th>Deletar</th>
      </tr>
    </thead>
    <tbody>
    <?php 
        $query = "SELECT * FROM professor";
        $stmt = $objProfessor->runQuery($query);
        $stmt->execute();
        while($objProfessor = $stmt->fetch(PDO::FETCH_ASSOC)){        
      ?>
            <tr>
              <td><?php echo($objProfessor['nome']); ?></td>
              <td><?php echo($objProfessor['email']); ?></td>
              <td>
                  <button type="button" class="btn btn-warning"
                  data-toggle="modal" 
                  data-target="#myModalEditar"
                  data-id="<?php echo($objProfessor['idprofessor']);?>"
                  data-nome="<?php echo($objProfessor['nome']);?>"
                  data-email="<?php echo($objProfessor['email']);?>"
                  >Editar</button>
              </td>
              <td>
                  <button type="button" class="btn btn-danger"
                  data-toggle="modal" data-target="#myModalDeletar" 
                  data-id="<?php echo($objProfessor['idprofessor']);?>"
                  data-nome="<?php echo($objProfessor['nome']);?>"
                  >Deletar</button>
              </td>
            </tr>
      <?php
        }
      ?>
    </tbody>
  </table>
</div>

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
         <form action="../controller/professorController.php" method="post">
             <input type="hidden" name="insertProfessor" >
        <div class="form-group">
            <label for="email">Nome:</label>
            <input type="text" class="form-control" placeholder="Nome do Professor..." id="Nome" name="txtNome">
        </div>
        <div class="form-group">
            <label for="pwd">Email:</label>
            <input type="text" class="form-control" placeholder="Email..." id="email" name="txtEmail"> 
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
  
</div>
<div class="modal" id="myModalDeletar">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" style="background-color: green; color: white;">
          <h4 class="modal-title">Apagar Professor</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <form action="../controller/professorController.php" method="post">
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
          <h4 class="modal-title">Editar Professor</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <form action="../controller/professorController.php" method="post">
             <input type="hidden" name="updateId" id="recipient-id">
             <div class="form-group">
            <label for="text">Nome do Curso:</label>
            <input type="text" class="form-control mb-3" placeholder="Novo nome" name="txtNome" id="recipient-nome">
            <div class="form-group">
            <label for="pwd">Email:</label>
            <input type="text" class="form-control" placeholder="Email..." id="recipiet-email" name="txtEmail"> 
        </div>
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
      var recipientEmail = button.data('email');
    
      var modal = $(this);
      modal.find('#recipient-id').val(recipientId);
      modal.find('#recipient-nome').val(recipientNome);
      modal.find('#recipiet-email').val(recipientEmail);     
    });
    </script>
</body>
</html> 
