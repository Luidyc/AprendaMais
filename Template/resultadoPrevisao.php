<?php
    require_once('../Model/turma.php');
    $objTurma = new Turma();
    require_once('../Model/disciplina.php');
    $objDisciplina = new Disciplina();
    require_once('../Model/aluno.php');
    $objAlunos = new Aluno();
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
    <title>Aprenda Mais - Ferramenta de Análise de Dados</title>
    <link rel="icon" type="image/x-icon" href="./img/Aprenda-Mais-logo.ico">
</head>
<body>
<?php 
  include('navegacao.php');
?>
<div class="container">
    <thead></thead>
    <?php
        $query = "SELECT nome, percentualregresso,iddisciplina FROM turma";
        $stmt = $objTurma->runQuery($query);
        $stmt->execute();
        $objTurma = $stmt->fetch(PDO::FETCH_ASSOC);   
        $objDisciplina = $objDisciplina->getDisciplinaByid($objTurma['iddisciplina']);  
        $AlunoQuery = "SELECT * FROM aluno";
        $result = $objAlunos->runQuery($AlunoQuery);
        $result->execute();
        $objAlunos = $result->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <body>
    <div class="container">
        <h4 class="text-center">Tuma Analisada: <?php echo($objTurma['nome']); ?> </h4>
        <h1 class="text-center">Resultado da Análise: <?php echo($objTurma['percentualregresso']); ?></h1>
        <h5 class="text-center">Disciplina : <?php echo($objDisciplina['nome']); ?></h5>
            foreach($objAlunos as $Aluno) {
                
            }
        <div class="row mt-2">
            <div class="text-center mt-2 col-md-4">
                <label for="resultados-negativos"><strong>Negativo ou Positivo:</strong></label>
                <ul id="resultados-negativos" class="list-group">
                    <li class="list-group-item">O valor é <strong>Negativo</strong>
                    <p>Oque podemos obter de interpretação é  à medida que as notas aumentam, 
                        a quantidade de faltas tende a diminuir, e vice-versa.</p>
                    </li>
                    <li class="list-group-item">O valor é <strong>Positivo</strong>
                    <p>Oque podemos obter de interpretação é  à medida que as notas aumentam, 
                        a quantidade de faltas tende a aumentar, e vice-versa.</p>
                    </li>
                </ul>
            </div>
            <div class="text-center mt-2 col-md-4">
                <label for="resultados-negativos"><strong>Quanto mais próximo de 1</strong></label>
                <ul id="resultados-negativos" class="list-group">
                    <li class="list-group-item">O valor obtido é 
                        <strong><?php echo($objTurma['percentualregresso']); ?></strong>
                    <p>O fato de o coeficiente de correlação estar próximo de 1 indica uma correlação forte.
                        Isso sugere que há uma relação linear forte entre as notas e as faltas.</p>
                    </li>
                    <li class="list-group-item">Caso o valor fosse 
                        <strong>0</strong>
                    <p>O fato de o coeficiente de correlação estar próximo de 0 indica que não existe relação.
                        Isso sugere que não há uma relação linear entre as notas e as faltas.</p>
                    </li>
                </ul>
            </div>
            <div class="text-center mt-2 col-md-4">
                <label for="resultados-negativos"><strong>Interpretações</strong></label>
                <ul id="resultados-negativos" class="list-group">
                    <li class="list-group-item">
                    <p>Podemos analisar os dados da seguinte forma : 
                        Os alunos que faltaram menos tendem a obter notas mais altas, 
                        e aqueles que faltaram mais frequentemente tendem a obter notas mais baixas.</p>
                    </li>
                    <li class="list-group-item">
                    <p> Vale ressaltar, que apesar da correlação entre notas e faltas ser forte.
                        Outros fatores podem estar envolvidos e influenciar essas variáveis.</p>
                    </li>
                </ul>
            </div>
</body>
  </table>
</div>