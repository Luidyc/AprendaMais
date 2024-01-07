<?php
    require_once '../model/disciplina.php';   
    $objDisciplina = new Disciplina();

    if(isset($_POST['insertDisciplina'])){
        $idCurso = $_POST['insertDisciplina'];
        $nome = $_POST['txtDiscplinaNome'];
        if($objDisciplina -> insert($nome,$idCurso)){
            $objDisciplina -> redirect('../Template/curso.php');
        }
    }

    if(isset($_POST['delete'])){
        $id = $_POST['delete'];
        if($objDisciplina -> deletar($id)){
            $objDisciplina -> redirect('../Template/disciplina.php');  
        }
    }

    if(isset($_POST['updateId'])){
        $nome = $_POST['txtNome'];
        $id = $_POST['updateId'];
        if($objDisciplina -> editar($nome,$id)){
            $objDisciplina -> redirect('../Template/disciplina.php');
        }
    }

?>