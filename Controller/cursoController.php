<?php
require_once '../model/curso.php';
$objCurso = new Curso();

if (isset($_POST['insert'])) {
    $nome = $_POST['txtNome'];

    if (empty($nome)) {
        $responseMessage = "Erro: Nome do Curso é obrigatório.";
    } elseif ($objCurso->isCursoExists($nome)) {
        $responseMessage = "Erro: Curso Já Existente.";
    } else {
        if ($objCurso->insert($nome)) {
            $objCurso->redirect('../Template/curso.php?cadastrado=' . urlencode($nome));
        } else {
            $responseMessage = "Erro: Falha ao inserir o Curso.";
        }
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['delete'];
    if ($objCurso->deletar($id)) {
        $objCurso->redirect('../Template/curso.php');
    }
}

if (isset($_POST['updateId'])) {
    $nome = $_POST['txtNome'];
    $id = $_POST['updateId'];
    if ($objCurso->editar($nome, $id)) {
        $objCurso->redirect('../Template/curso.php');
    }
}

if (isset($responseMessage)) {
    $objCurso->redirect('../Template/curso.php?message=' . urlencode($responseMessage));
}

?>
