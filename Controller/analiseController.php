<?php
    session_start();
    $_SESSION['idTurma'] = $_POST['turma'];
    require_once '../model/analise.php';   
    $objAnalise = new Analise();

    if(isset($_POST['calcularRegressao'])){
        $idturma = $_POST['turma'];
        if($objAnalise -> insertPercentual($idturma)){
            $objAnalise -> redirect('../Template/resultado.php');
        }
    }

?>