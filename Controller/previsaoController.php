<?php
    require_once '../model/previsao.php';   
    $objPrevisao = new Previsao();

    if(isset($_POST['calcularPrevisao'])){
        $idturma = $_POST['turma'];
        if($objPrevisao -> preverNotas($idturma)){
            $objPrevisao -> echo($objPrevisao->preverNotas($idturma));
        }
    }

?>