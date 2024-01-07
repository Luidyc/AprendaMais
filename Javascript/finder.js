async function pesquisar() {
    var turma_id = document.getElementById("idturma").value;
    console.log(turma_id);

    var dados = await fetch("pesquisar.php?idturma="+turma_id);

    var resposta = await dados.json();
    console.log(resposta);
}

