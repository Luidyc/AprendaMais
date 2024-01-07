<?php
    require_once '../model/turma.php';   
    $objTurma = new Turma();
    ini_set("display_errors", 1);
    if(isset($_POST['insertTurma'])){
        $nome = $_POST['txtNome'];
        $tipoDeTurma = $_POST['txtTipoDeTurma'];
        $professor = $_POST['professor'];
        $disciplina = $_POST['disciplina'];
        if($objTurma -> insert($nome,$tipoDeTurma,$professor,$disciplina)){
            $objTurma -> redirect('../Template/turma.php');
        }
    }

    if(isset($_POST['delete'])){
        $id = $_POST['delete'];
        if($objTurma -> deletar($id)){
            $objTurma -> redirect('../Template/turma.php');  
        }
    }

    

    if(isset($_POST['updateId'])){
        $nome = $_POST['txtNome'];
        $tipoDeTurma = $_POST['txtTipoDeTurma'];
        $professor = $_POST['professor'];
        $disciplina = $_POST['disciplina'];
        $idturma = $_POST['updateId'];
        if($objTurma -> editar($idturma,$nome,$tipoDeTurma,$professor,$disciplina)){
            $objTurma -> redirect('../Template/turma.php');
        }
    }

?>