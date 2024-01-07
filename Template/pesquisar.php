<?php 
// Recebe dados do JS
$turma_id = filter_input(INPUT_GET,'idturma',FILTER_SANITIZE_NUMBER_INT);

if(!empty($turma_id)) {
    $response = ['status' => true, 'idturma' => $turma_id];
} else {
    $response = ['status' => false, 'msg' => "<p style='color: #f00;'>Erro:Desculpe houve um erro!</p>"];
}

echo json_encode($response);

