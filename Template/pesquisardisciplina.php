<?php 
// Recebe dados do JS
$disciplina_id = filter_input(INPUT_GET,'iddisciplina',FILTER_SANITIZE_NUMBER_INT);

if(!empty($disciplina_id)) {
    $responses = ['status' => true, 'iddisciplina' => $disciplina_id];
} else {
    $responses = ['status' => false, 'msg' => "<p style='color: #f00;'>Erro:Desculpe houve um erro!</p>"];
}

echo json_encode($responses);