<?php

require_once('../Model/previsao.php');


if (isset($_POST['idturma'])) {
    $idturma = $_POST['idturma'];


    $objPrevisao = new Previsao();


    $resultados = $objPrevisao->preverNotas($idturma);

    echo $resultados;
} else {
    echo 'Erro: ID da turma não fornecido.';
}
