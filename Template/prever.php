<?php

class PreverNotasComFaltas {
    public static function main() {
        // Faltas de todos alunos daquela disciplina (Não somente da turma)
        // Para treinar vou trazer vou dar select em todas turmas finalizadas na matéria para realizar a previsão
        $faltas = [66,57,0,9,12,12,36,19,0,0,3,6,3,18,66,12,3,66,0,18,3,9,12,12,9,0,66,15,10,6,12];

        // Notas correspondentes a disciplina (para treinamento do modelo)
        $notas = [0,0,10,6.5,9.5,8.7,0,3.2,6.3,9.7,7.5,8.8,8.7,6,0,6.2,9.3,0,8.7,6.5,10,5.5,6,6.8,9.3,9.3,0,6.5,8,8.7,8.3];

        // Realizo treinamento com todas turmas finalizadas na disciplina e Ajustando a regressão
        $modelo = self::ajustarRegressaoLinear($faltas, $notas);

        // Quantidade de faltas de cada aluno na matéria em aberto na disciplina.
        $faltasParaPrever = 12;

        // Prever as notas com base nas faltas usando o modelo ajustado
        $previsaoNotas = self::preverNotas($faltasParaPrever, $modelo);

        echo "Previsão de notas para $faltasParaPrever faltas: " . $previsaoNotas . "\n";
    }

    // Função para ajustar um modelo de regressão linear
    public static function ajustarRegressaoLinear($faltas, $notas) {
        $quantidadeDeFaltas = count($faltas);

        // Calcular as somas necessárias
        $somaFaltas = array_sum($faltas);
        $somaFaltasQuadrado = array_sum(array_map(function($x) { return $x * $x; }, $faltas));
        $somaNotas = array_sum($notas);
        $somaProdutos = array_sum(array_map(function($x, $y) { return $x * $y; }, $faltas, $notas));

        // Calcular os coeficientes da regressão linear (m e b)
        $m = ($quantidadeDeFaltas * $somaProdutos - $somaFaltas * $somaNotas) / ($quantidadeDeFaltas * $somaFaltasQuadrado - pow($somaFaltas, 2));
        $b = ($somaNotas - $m * $somaFaltas) / $quantidadeDeFaltas;

        return ['m' => $m, 'b' => $b];
    }

    // Função para prever notas com base nas faltas usando o modelo ajustado
    public static function preverNotas($faltas, $modelo) {
        // Suponha que o intercepto seja zero para simplificar
        return $modelo['m'] * $faltas + $modelo['b'];
    }
}

// Executar o programa
PreverNotasComFaltas::main();
?>